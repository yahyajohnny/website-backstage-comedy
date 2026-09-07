<?php
declare(strict_types=1);

/**
 * Cron / CLI: refresh events cache and optionally rewrite sitemap.
 *
 * Recommended crontab (Europe/Berlin):
 *   5 0 * * * php /path/to/cron/refresh-events.php
 *   Plus a job shortly after typical show end, e.g.:
 *   5 22 * * * php /path/to/cron/refresh-events.php
 */
require_once dirname(__DIR__) . '/lib/events.php';
require_once dirname(__DIR__) . '/lib/sitemap.php';

bcn_refresh_events_cache(true);
bcn_write_sitemap();

echo 'OK ' . bcn_now()->format(DateTimeInterface::ATOM) . ' events=' . count(bcn_upcoming_events()) . PHP_EOL;
