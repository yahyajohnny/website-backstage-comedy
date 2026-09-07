<?php
declare(strict_types=1);

require_once __DIR__ . '/events.php';

function bcn_lastmod_map(): array
{
    $map = bcn_read_json_file(bcn_cache_path('url-lastmod.json'));
    return is_array($map) ? $map : [];
}

function bcn_set_lastmod(string $path, string $dateYmd): void
{
    $map = bcn_lastmod_map();
    $map[$path] = $dateYmd;
    bcn_write_json_file(bcn_cache_path('url-lastmod.json'), $map);
}

function bcn_lastmod_for(string $path): ?string
{
    $map = bcn_lastmod_map();
    return isset($map[$path]) ? (string) $map[$path] : null;
}

function bcn_sitemap_urls(): array
{
    $urls = [
        '/',
        '/stand-up-comedy-muenchen/',
        '/comedy-club-muenchen/',
        '/termine/',
        '/tickets/',
        '/backstage-muenchen-comedy/',
        '/comedy-muenchen-heute/',
        '/comedy-muenchen-wochenende/',
        '/gruppen-firmenevents/',
        '/galerie.html',
        '/impressum.html',
        '/datenschutz.html',
    ];

    // Upcoming events in sitemap; past events stay reachable but are omitted
    // unless already listed with a lastmod (archive discovery via internal links).
    foreach (bcn_upcoming_events() as $event) {
        $urls[] = bcn_event_path($event);
    }

    // Keep recently past events discoverable for a while if present in archive lastmod
    foreach (bcn_load_raw_events(true) as $event) {
        if (bcn_is_upcoming($event)) {
            continue;
        }
        $path = bcn_event_path($event);
        // Include past events from the last 180 days for archival SEO
        $ageDays = (int) $event['endDt']->diff(bcn_now())->format('%a');
        if ($ageDays <= 180) {
            $urls[] = $path;
        }
    }

    return array_values(array_unique($urls));
}

function bcn_write_sitemap(): void
{
    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach (bcn_sitemap_urls() as $path) {
        $loc = bcn_url($path);
        $lastmod = bcn_lastmod_for($path);
        $xml .= "  <url>\n";
        $xml .= '    <loc>' . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
        if ($lastmod) {
            $xml .= '    <lastmod>' . htmlspecialchars($lastmod, ENT_XML1) . "</lastmod>\n";
        }
        $xml .= "  </url>\n";
    }
    $xml .= '</urlset>' . "\n";
    file_put_contents(bcn_root() . '/sitemap.xml', $xml, LOCK_EX);
}
