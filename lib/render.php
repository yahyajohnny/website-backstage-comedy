<?php
declare(strict_types=1);

require_once __DIR__ . '/events.php';

function bcn_json_ld(array $data): string
{
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    return '<script type="application/ld+json">' . $json . '</script>';
}

function bcn_ticket_attrs(array $event): string
{
    $slug = bcn_esc($event['slug']);
    $name = bcn_esc($event['name']);
    return ' class="js-ticket-link" data-ticket-slug="' . $slug . '" data-ticket-name="' . $name . '"';
}

/**
 * Shared show card (homepage /termine/ grid).
 */
function bcn_render_show_card(array $event, ?DateTimeImmutable $now = null, array $opts = []): string
{
    $now ??= bcn_now();
    $upcoming = bcn_is_upcoming($event, $now);
    $isToday = $upcoming && $event['startDt']->format('Y-m-d') === $now->format('Y-m-d');
    $images = bcn_local_event_images($event);
    $imgSrc = $images['16x9'];
    $alt = 'Backstage Comedy Night München – ' . bcn_format_date_short($event['startDt']);

    $badge = '';
    if ($event['soldOut']) {
        $badge = '<span class="show-badge badge-soldout">Ausverkauft</span>';
    } elseif ($isToday) {
        $badge = '<span class="show-badge badge-today">Heute!</span>';
    }

    $priceHtml = $event['minPrice'] !== null
        ? '<div class="show-price">' . bcn_esc(bcn_price_label($event['minPrice'])) . '</div>'
        : '<div class="show-price">Tickets im Vorverkauf</div>';

    if (!$upcoming) {
        $cta = '<a href="' . bcn_esc(bcn_event_path($event)) . '" class="show-cta">Rückblick &amp; Infos →</a>';
        $priceHtml = '<div class="show-price">Vergangene Show</div>';
    } elseif ($event['soldOut']) {
        $cta = '<a href="/termine/" class="show-cta">Weitere Termine →</a>';
        $priceHtml = '<div class="show-price" style="color:#ff4d4d;font-weight:600;">Ausverkauft</div>';
    } else {
        $cta = '<a href="' . bcn_esc($event['ticketUrl']) . '" target="_blank" rel="noopener noreferrer"' . bcn_ticket_attrs($event) . ' class="show-cta js-ticket-link">Tickets sichern →</a>';
    }

    $detail = '<a href="' . bcn_esc(bcn_event_path($event)) . '" class="event-detail-link">Alle Infos zur Show →</a>';
    $dateLong = bcn_format_date_long($event['startDt']);

    return <<<HTML
    <article class="show-card" data-event-slug="{$event['slug']}" data-event-end="{$event['end']}" data-event-start="{$event['start']}">
      <div class="show-card-image"><img src="{$imgSrc}" alt="{$alt}" loading="lazy" width="1200" height="675">{$badge}</div>
      <div class="show-card-body">
        <div class="show-date">{$dateLong}</div>
        <div class="show-time">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Einlass {$event['doorsDt']->format('H:i')} Uhr · Show {$event['startDt']->format('H:i')} Uhr
        </div>
        <div class="show-name">{$event['name']}</div>
        <div class="show-location">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          Backstage München
        </div>
        <div class="show-footer">
          {$priceHtml}
          {$cta}
        </div>
        {$detail}
      </div>
    </article>
HTML;
}

function bcn_render_show_grid(array $events, ?DateTimeImmutable $now = null, array $opts = []): string
{
    $now ??= bcn_now();
    if (!$events) {
        return '<div class="shows-empty"><p>Neue Termine kommen bald. Folge uns auf Instagram, um nichts zu verpassen.</p><a href="' . bcn_esc(BCN_INSTAGRAM) . '" target="_blank" rel="noopener noreferrer">@backstage.comedy.night →</a></div>';
    }
    $html = '';
    foreach ($events as $event) {
        $html .= bcn_render_show_card($event, $now, $opts);
    }
    return $html;
}

/**
 * Compact event card for landing pages.
 */
function bcn_render_event_card(array $event, ?DateTimeImmutable $now = null): string
{
    $now ??= bcn_now();
    $upcoming = bcn_is_upcoming($event, $now);
    $price = bcn_price_label($event['minPrice']);
    $desc = 'Stand-up Comedy in München mit mehreren Comedians und wechselndem Line-up. '
        . ($price !== '' ? bcn_esc($price) . '.' : 'Tickets im Vorverkauf.');
    $date = bcn_esc(bcn_format_date_long($event['startDt']));
    $doors = bcn_esc(bcn_format_time($event['doorsDt']));
    $start = bcn_esc(bcn_format_time($event['startDt']));
    $name = bcn_esc($event['name']);
    $slug = bcn_esc($event['slug']);

    if (!$upcoming) {
        $status = '<p class="event-card-meta"><strong>Diese Show hat bereits stattgefunden.</strong></p>';
        $footer = '<a href="' . bcn_esc(bcn_event_path($event)) . '" class="btn btn-secondary btn-sm">Zur Eventseite →</a>';
    } elseif ($event['soldOut']) {
        $status = '';
        $footer = '<span class="badge-soldout-inline">Ausverkauft</span> <a href="/termine/" class="event-detail-link">Weitere Termine ansehen →</a>';
    } else {
        $status = '';
        $footer = '<a href="' . bcn_esc($event['ticketUrl']) . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm js-ticket-link"' . bcn_ticket_attrs($event) . '>Tickets sichern →</a>'
            . '<a href="' . bcn_esc(bcn_event_path($event)) . '" class="event-detail-link">Details &amp; Infos zur Show →</a>';
    }

    return <<<HTML
    <article class="event-card" data-event-slug="{$slug}" data-event-end="{$event['end']}" data-event-start="{$event['start']}">
      <h3 class="event-card-title">{$name}</h3>
      {$status}
      <p class="event-card-meta"><strong>{$date}</strong></p>
      <p class="event-card-meta">Einlass: {$doors} Uhr · Beginn: {$start} Uhr</p>
      <p class="event-card-meta">Backstage München, Reitknechtstr. 6, 80639 München</p>
      <p class="event-card-desc">{$desc}</p>
      <div class="event-card-footer">{$footer}</div>
    </article>
HTML;
}

function bcn_render_event_list(array $events, ?DateTimeImmutable $now = null): string
{
    if (!$events) {
        return '<p>Aktuell sind keine Termine in dieser Auswahl verfügbar. Schau in die <a href="/termine/">Terminübersicht</a>.</p>';
    }
    $html = '<div class="event-list">';
    foreach ($events as $event) {
        $html .= bcn_render_event_card($event, $now);
    }
    $html .= '</div>';
    return $html;
}

function bcn_schema_organization(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => bcn_url('/#organization'),
        'name' => BCN_SITE_NAME,
        'alternateName' => BCN_SITE_NAME_FULL,
        'url' => bcn_url('/'),
        'email' => BCN_EMAIL,
        'image' => bcn_url('/assets/og-image.jpg'),
        'logo' => bcn_url('/assets/logo.png'),
        'description' => 'Monatliche Stand-up-Comedy-Show im Backstage München mit wechselndem Line-up.',
        'sameAs' => [BCN_INSTAGRAM],
        'founder' => [
            [
                '@type' => 'Person',
                'name' => 'Yahya Pervaiz',
                'jobTitle' => 'Comedian & Co-Founder',
                'sameAs' => 'https://www.instagram.com/yahya.pervaiz/',
            ],
            [
                '@type' => 'Person',
                'name' => 'Bilal Mohammed',
                'jobTitle' => 'Comedian, Moderator & Co-Founder',
                'sameAs' => 'https://www.instagram.com/bilal.comedy/',
            ],
        ],
    ];
}

function bcn_schema_website(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => BCN_SITE_NAME_FULL,
        'url' => bcn_url('/'),
        'description' => 'Comedy Show in München: monatliche Stand-up Comedy Night im Backstage.',
        'inLanguage' => 'de',
        'publisher' => ['@id' => bcn_url('/#organization')],
    ];
}

function bcn_schema_event_series(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'EventSeries',
        'name' => BCN_SITE_NAME_FULL,
        'description' => 'Monatliche Stand-up-Comedy-Show im Backstage München mit mehreren Comedians.',
        'url' => bcn_url('/'),
        'location' => bcn_schema_place(),
        'organizer' => [
            '@type' => 'Organization',
            'name' => BCN_SITE_NAME,
            'url' => bcn_url('/'),
        ],
        'typicalAgeRange' => '18-',
        'inLanguage' => 'de',
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
    ];
}

function bcn_schema_place(): array
{
    return [
        '@type' => 'Place',
        'name' => BCN_LOCATION['name'],
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => BCN_LOCATION['street'],
            'addressLocality' => BCN_LOCATION['city'],
            'postalCode' => BCN_LOCATION['postal'],
            'addressCountry' => BCN_LOCATION['country'],
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => BCN_LOCATION['lat'],
            'longitude' => BCN_LOCATION['lng'],
        ],
    ];
}

function bcn_schema_breadcrumb(array $items): array
{
    $list = [];
    $pos = 1;
    foreach ($items as $item) {
        $entry = [
            '@type' => 'ListItem',
            'position' => $pos++,
            'name' => $item['name'],
        ];
        if (!empty($item['url'])) {
            $entry['item'] = $item['url'];
        }
        $list[] = $entry;
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $list,
    ];
}

function bcn_schema_faq(array $faqs): array
{
    $entities = [];
    foreach ($faqs as $faq) {
        $entities[] = [
            '@type' => 'Question',
            'name' => $faq['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['a'],
            ],
        ];
    }
    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $entities,
    ];
}

/**
 * Exactly one ComedyEvent for detail pages.
 */
function bcn_schema_comedy_event(array $event, ?DateTimeImmutable $now = null): array
{
    $now ??= bcn_now();
    $upcoming = bcn_is_upcoming($event, $now);
    $images = bcn_local_event_images($event);

    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'ComedyEvent',
        'name' => $event['name'],
        'description' => 'Stand-up Comedy in München live im Backstage: kuratierte Mixed Show mit mehreren Comedians und wechselndem Line-up. Einlass '
            . bcn_format_time($event['doorsDt']) . ' Uhr, Beginn ' . bcn_format_time($event['startDt']) . ' Uhr.',
        'startDate' => $event['start'],
        'endDate' => $event['end'],
        'doorTime' => $event['doors'],
        'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
        'eventStatus' => $upcoming
            ? ($event['soldOut'] ? 'https://schema.org/EventScheduled' : 'https://schema.org/EventScheduled')
            : 'https://schema.org/EventScheduled',
        'inLanguage' => 'de',
        'url' => bcn_event_url($event),
        'image' => [
            bcn_url($images['1x1']),
            bcn_url($images['4x3']),
            bcn_url($images['16x9']),
        ],
        'location' => bcn_schema_place(),
        'organizer' => [
            '@type' => 'Organization',
            'name' => BCN_SITE_NAME,
            'url' => bcn_url('/'),
        ],
    ];

    if (!empty($event['lineup'])) {
        $performers = [];
        foreach ($event['lineup'] as $name) {
            $performers[] = [
                '@type' => 'Person',
                'name' => $name,
            ];
        }
        $data['performer'] = count($performers) === 1 ? $performers[0] : $performers;
    }

    if ($upcoming && $event['ticketUrl'] !== '') {
        $offer = [
            '@type' => 'Offer',
            'url' => $event['ticketUrl'],
            'priceCurrency' => 'EUR',
            'availability' => $event['soldOut']
                ? 'https://schema.org/SoldOut'
                : 'https://schema.org/InStock',
        ];
        if ($event['minPrice'] !== null) {
            $offer['price'] = $event['minPrice'] + 0; // JSON number
        }
        $data['offers'] = $offer;
    }

    return $data;
}

function bcn_breadcrumb_html(array $items): string
{
    $parts = [];
    $last = count($items) - 1;
    foreach ($items as $i => $item) {
        if ($i > 0) {
            $parts[] = '<span aria-hidden="true">›</span>';
        }
        if ($i === $last || empty($item['url'])) {
            $parts[] = '<span aria-current="page">' . bcn_esc($item['name']) . '</span>';
        } else {
            $parts[] = '<a href="' . bcn_esc($item['url']) . '">' . bcn_esc($item['name']) . '</a>';
        }
    }
    return '<nav class="breadcrumb" aria-label="Breadcrumb">' . implode('', $parts) . '</nav>';
}

function bcn_gallery_files(): array
{
    $path = bcn_root() . '/assets/galerie/index.json';
    $files = bcn_read_json_file($path);
    return array_values(array_filter($files, 'is_string'));
}

function bcn_gallery_alt(string $file, int $index): string
{
    $alts = [
        'Bühne der Backstage Comedy Night im Backstage München',
        'Publikum bei der Backstage Comedy Night in München',
        'Stand-up-Auftritt bei der Backstage Comedy Night',
        'Clubatmosphäre im Backstage München während der Comedy Night',
        'Live-Moment auf der Bühne der Backstage Comedy Night',
        'Zuschauer bei einer Stand-up-Show im Backstage München',
        'Scheinwerfer und Bühne bei der Backstage Comedy Night',
        'Comedy-Abend im Backstage München',
        'Impression von der Backstage Comedy Night München',
        'Weitere Impression der monatlichen Comedy Show im Backstage',
        'Atmosphäre vor Showbeginn im Backstage München',
        'Nach der Show: Eindrücke der Backstage Comedy Night',
    ];
    return $alts[$index % count($alts)];
}

function bcn_render_gallery_grid(int $limit = 12, bool $lazyBelowFold = true): string
{
    $files = array_slice(bcn_gallery_files(), 0, $limit);
    if (!$files) {
        return '';
    }
    $html = '';
    foreach ($files as $i => $file) {
        $src = '/assets/galerie/' . rawurlencode($file);
        // Also try webp/avif variants if present
        $base = pathinfo($file, PATHINFO_FILENAME);
        $webp = '/assets/galerie/optimized/' . $base . '.webp';
        $avif = '/assets/galerie/optimized/' . $base . '.avif';
        $hasWebp = is_file(bcn_root() . $webp);
        $hasAvif = is_file(bcn_root() . $avif);
        $alt = bcn_esc(bcn_gallery_alt($file, $i));
        $loading = ($lazyBelowFold && $i >= 2) ? 'lazy' : 'eager';
        $img = '';
        if ($hasAvif || $hasWebp) {
            $img .= '<picture>';
            if ($hasAvif) {
                $img .= '<source type="image/avif" srcset="' . bcn_esc($avif) . '">';
            }
            if ($hasWebp) {
                $img .= '<source type="image/webp" srcset="' . bcn_esc($webp) . '">';
            }
            $img .= '<img src="' . bcn_esc($src) . '" alt="' . $alt . '" loading="' . $loading . '" width="400" height="300">';
            $img .= '</picture>';
        } else {
            $img = '<img src="' . bcn_esc($src) . '" alt="' . $alt . '" loading="' . $loading . '" width="400" height="300">';
        }
        $delay = ($i % 4) + 1;
        $html .= '<div class="gallery-item reveal reveal-delay-' . $delay . '">' . $img . '<div class="gallery-overlay"></div></div>';
    }
    return $html;
}

function bcn_next_ticket_cta(?array $next = null): string
{
    $next ??= bcn_next_event();
    if (!$next) {
        return '<a href="/termine/" class="btn btn-primary">Alle Termine ansehen</a>';
    }
    if ($next['soldOut']) {
        return '<a href="/termine/" class="btn btn-primary">Ausverkauft – weitere Termine</a>';
    }
    $label = 'Tickets für den ' . bcn_format_date_short($next['startDt']) . ' sichern';
    return '<a href="' . bcn_esc($next['ticketUrl']) . '" target="_blank" rel="noopener noreferrer" class="btn btn-primary js-ticket-link"' . bcn_ticket_attrs($next) . '>' . bcn_esc($label) . '</a>';
}
