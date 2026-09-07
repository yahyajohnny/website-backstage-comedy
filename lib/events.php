<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/**
 * Central event data layer.
 * Upcoming = end > now (Europe/Berlin).
 */
function bcn_parse_dt(string $iso): DateTimeImmutable
{
    $dt = new DateTimeImmutable($iso);
    return $dt->setTimezone(new DateTimeZone(BCN_TIMEZONE));
}

function bcn_normalize_event(array $raw): ?array
{
    if (empty($raw['slug']) || empty($raw['start']) || empty($raw['name'])) {
        return null;
    }

    $start = bcn_parse_dt((string) $raw['start']);
    $doors = !empty($raw['doors']) ? bcn_parse_dt((string) $raw['doors']) : $start->modify('-1 hour');
    $end = !empty($raw['end']) ? bcn_parse_dt((string) $raw['end']) : $start->modify('+2 hours');

    $price = array_key_exists('minPrice', $raw) && $raw['minPrice'] !== null
        ? (float) $raw['minPrice']
        : null;

    $image = (string) ($raw['image'] ?? '');
    if ($image === '') {
        $image = bcn_url('/assets/events/poster-16x9.webp');
    }

    $lineup = [];
    if (!empty($raw['lineup']) && is_array($raw['lineup'])) {
        foreach ($raw['lineup'] as $act) {
            $name = is_string($act) ? trim($act) : trim((string) ($act['name'] ?? ''));
            if ($name !== '') {
                $lineup[] = $name;
            }
        }
    }

    return [
        'name' => (string) $raw['name'],
        'start' => $start->format(DateTimeInterface::ATOM),
        'doors' => $doors->format(DateTimeInterface::ATOM),
        'end' => $end->format(DateTimeInterface::ATOM),
        'soldOut' => (bool) ($raw['soldOut'] ?? false),
        'minPrice' => $price,
        'ticketUrl' => (string) ($raw['ticketUrl'] ?? ''),
        'provider' => (string) ($raw['provider'] ?? 'Snapticket'),
        'image' => $image,
        'slug' => (string) $raw['slug'],
        'lineup' => $lineup,
        'startDt' => $start,
        'doorsDt' => $doors,
        'endDt' => $end,
    ];
}

function bcn_read_json_file(string $path): array
{
    if (!is_file($path)) {
        return [];
    }
    $raw = file_get_contents($path);
    if ($raw === false || $raw === '') {
        return [];
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function bcn_write_json_file(string $path, array $data): void
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    file_put_contents(
        $path,
        json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . "\n",
        LOCK_EX
    );
}

/**
 * Merge events by slug (newer/non-empty fields win from $incoming).
 */
function bcn_merge_events(array $existing, array $incoming): array
{
    $bySlug = [];
    foreach ($existing as $e) {
        if (!empty($e['slug'])) {
            $bySlug[$e['slug']] = $e;
        }
    }
    foreach ($incoming as $e) {
        if (empty($e['slug'])) {
            continue;
        }
        $prev = $bySlug[$e['slug']] ?? [];
        $bySlug[$e['slug']] = array_merge($prev, $e);
    }
    $all = array_values($bySlug);
    usort($all, static fn(array $a, array $b): int => strcmp((string) $a['start'], (string) $b['start']));
    return $all;
}

function bcn_fetch_upstream_events(): ?array
{
    // Optional private adapter (not in git): lib/upstream-events.php
    $adapter = __DIR__ . '/upstream-events.php';
    if (is_file($adapter)) {
        require_once $adapter;
        if (function_exists('bcn_fetch_vivenu_events')) {
            $fromAdapter = bcn_fetch_vivenu_events();
            if (is_array($fromAdapter)) {
                return $fromAdapter;
            }
        }
    }

    $upstream = getenv(BCN_EVENTS_UPSTREAM_ENV) ?: '';
    // Optional: local bootstrap from previously known public endpoint during migration.
    if ($upstream === '' && is_file(bcn_cache_path('.use-live-bootstrap'))) {
        $upstream = 'https://www.backstage-comedy.de/api-events.php';
    }
    if ($upstream === '') {
        return null;
    }

    $ctx = stream_context_create([
        'http' => [
            'timeout' => 8,
            'header' => "Accept: application/json\r\nUser-Agent: BackstageComedyNight/1.0\r\n",
        ],
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
        ],
    ]);
    $raw = @file_get_contents($upstream, false, $ctx);
    if ($raw === false) {
        return null;
    }
    $data = json_decode($raw, true);
    return is_array($data) ? $data : null;
}

/**
 * Refresh cache from upstream when TTL expired. Always merges into archive.
 */
function bcn_refresh_events_cache(bool $force = false): void
{
    $cacheFile = bcn_cache_path('events.json');
    $metaFile = bcn_cache_path('events-meta.json');
    $meta = bcn_read_json_file($metaFile);
    $fetchedAt = isset($meta['fetchedAt']) ? (int) $meta['fetchedAt'] : 0;
    if (!$force && $fetchedAt > 0 && (time() - $fetchedAt) < BCN_EVENTS_CACHE_TTL) {
        return;
    }

    $incoming = bcn_fetch_upstream_events();
    if ($incoming === null) {
        // Keep existing cache; still stamp meta so we don't hammer missing upstream.
        if (!is_file($cacheFile)) {
            return;
        }
        bcn_write_json_file($metaFile, [
            'fetchedAt' => time(),
            'source' => 'cache-only',
        ]);
        return;
    }

    $normalized = [];
    foreach ($incoming as $row) {
        if (!is_array($row)) {
            continue;
        }
        // Persist raw-ish shape without DateTime objects
        $n = bcn_normalize_event($row);
        if ($n === null) {
            continue;
        }
        unset($n['startDt'], $n['doorsDt'], $n['endDt']);
        $normalized[] = $n;
    }

    $archivePath = bcn_cache_path('events-archive.json');
    $archive = bcn_read_json_file($archivePath);
    $mergedArchive = bcn_merge_events($archive, $normalized);
    bcn_write_json_file($archivePath, $mergedArchive);
    bcn_write_json_file($cacheFile, $normalized);
    bcn_write_json_file($metaFile, [
        'fetchedAt' => time(),
        'source' => 'upstream',
        'count' => count($normalized),
    ]);
}

function bcn_load_raw_events(bool $includePast = true): array
{
    bcn_refresh_events_cache(false);

    $upcomingRaw = bcn_read_json_file(bcn_cache_path('events.json'));
    if ($includePast) {
        $archive = bcn_read_json_file(bcn_cache_path('events-archive.json'));
        $raw = bcn_merge_events($archive, $upcomingRaw);
    } else {
        $raw = $upcomingRaw;
    }

    $events = [];
    foreach ($raw as $row) {
        if (!is_array($row)) {
            continue;
        }
        $n = bcn_normalize_event($row);
        if ($n !== null) {
            $events[] = $n;
        }
    }
    usort($events, static fn(array $a, array $b): int => $a['startDt'] <=> $b['startDt']);
    return $events;
}

function bcn_is_upcoming(array $event, ?DateTimeImmutable $now = null): bool
{
    $now ??= bcn_now();
    return $event['endDt'] > $now;
}

function bcn_upcoming_events(?DateTimeImmutable $now = null): array
{
    $now ??= bcn_now();
    $out = [];
    foreach (bcn_load_raw_events(true) as $event) {
        if (bcn_is_upcoming($event, $now)) {
            $out[] = $event;
        }
    }
    return $out;
}

function bcn_next_event(?DateTimeImmutable $now = null): ?array
{
    $upcoming = bcn_upcoming_events($now);
    return $upcoming[0] ?? null;
}

function bcn_event_by_slug(string $slug, ?DateTimeImmutable $now = null): ?array
{
    foreach (bcn_load_raw_events(true) as $event) {
        if ($event['slug'] === $slug) {
            return $event;
        }
    }
    return null;
}

function bcn_events_today(?DateTimeImmutable $now = null): array
{
    $now ??= bcn_now();
    $day = $now->format('Y-m-d');
    $out = [];
    foreach (bcn_upcoming_events($now) as $event) {
        if ($event['startDt']->format('Y-m-d') === $day) {
            $out[] = $event;
        }
    }
    return $out;
}

/**
 * Upcoming events whose start falls on Fri/Sat/Sun.
 * Prefer the next weekend window; if empty, return later weekend dates.
 */
function bcn_weekend_events(?DateTimeImmutable $now = null): array
{
    $now ??= bcn_now();
    $upcoming = bcn_upcoming_events($now);

    $weekend = [];
    foreach ($upcoming as $event) {
        $dow = (int) $event['startDt']->format('N'); // 1=Mon … 7=Sun
        if ($dow >= 5) {
            $weekend[] = $event;
        }
    }
    return $weekend;
}

/**
 * Events on the upcoming Fri–Sun window (relative to "now").
 */
function bcn_next_weekend_window_events(?DateTimeImmutable $now = null): array
{
    $now ??= bcn_now();
    $dow = (int) $now->format('N');
    // Start of this week's Friday (or next Friday if already past Sunday night framing)
    if ($dow <= 5) {
        $friday = $now->modify('friday this week')->setTime(0, 0, 0);
    } elseif ($dow === 6) {
        $friday = $now->modify('friday this week')->setTime(0, 0, 0);
    } else { // Sunday
        $friday = $now->modify('friday this week')->setTime(0, 0, 0);
    }
    // If today is Mon-Thu, friday this week is correct. If Fri-Sun, use this weekend.
    if ($dow >= 1 && $dow <= 4) {
        $friday = $now->modify('friday this week')->setTime(0, 0, 0);
    } else {
        $friday = $now->modify('friday this week')->setTime(0, 0, 0);
        if ($dow === 7 && (int) $now->format('H') >= 23) {
            $friday = $now->modify('friday next week')->setTime(0, 0, 0);
        }
    }
    $sundayEnd = $friday->modify('+2 days')->setTime(23, 59, 59);

    $inWindow = [];
    foreach (bcn_upcoming_events($now) as $event) {
        if ($event['startDt'] >= $friday && $event['startDt'] <= $sundayEnd) {
            $inWindow[] = $event;
        }
    }
    return $inWindow;
}

/**
 * Public API payload (upcoming only, JSON-serializable).
 */
function bcn_api_events_payload(?DateTimeImmutable $now = null): array
{
    $payload = [];
    foreach (bcn_upcoming_events($now) as $event) {
        $payload[] = [
            'name' => $event['name'],
            'start' => $event['start'],
            'doors' => $event['doors'],
            'end' => $event['end'],
            'soldOut' => $event['soldOut'],
            'minPrice' => $event['minPrice'],
            'ticketUrl' => $event['ticketUrl'],
            'image' => $event['image'],
            'slug' => $event['slug'],
            'provider' => $event['provider'],
            'lineup' => $event['lineup'],
        ];
    }
    return $payload;
}

function bcn_format_date_long(DateTimeImmutable $dt): string
{
    $days = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
    $months = [1 => 'Januar', 2 => 'Februar', 3 => 'März', 4 => 'April', 5 => 'Mai', 6 => 'Juni', 7 => 'Juli', 8 => 'August', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Dezember'];
    return $days[(int) $dt->format('N') - 1] . ', ' . $dt->format('d') . '. ' . $months[(int) $dt->format('n')] . ' ' . $dt->format('Y');
}

function bcn_format_date_short(DateTimeImmutable $dt): string
{
    return $dt->format('d.m.Y');
}

function bcn_format_time(DateTimeImmutable $dt): string
{
    return $dt->format('H:i');
}

function bcn_format_price(?float $price): string
{
    if ($price === null) {
        return '';
    }
    if (abs($price - round($price)) < 0.001) {
        return (string) (int) round($price);
    }
    return number_format($price, 2, ',', '.');
}

function bcn_price_label(?float $price, bool $neutralFallback = true): string
{
    if ($price !== null) {
        return 'ab ' . bcn_format_price($price) . ' €';
    }
    return $neutralFallback ? 'Tickets im Vorverkauf' : '';
}

function bcn_event_path(array $event): string
{
    return '/termine/' . $event['slug'] . '/';
}

function bcn_event_url(array $event): string
{
    return bcn_url(bcn_event_path($event));
}

function bcn_local_event_images(array $event): array
{
    // Prefer local optimized variants; fall back to remote image.
    $base = '/assets/events/poster';
    return [
        '1x1' => $base . '-1x1.webp',
        '4x3' => $base . '-4x3.webp',
        '16x9' => $base . '-16x9.webp',
        'remote' => $event['image'],
    ];
}
