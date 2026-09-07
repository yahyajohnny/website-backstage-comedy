# Deployment notes (All-inkl)

1. Upload the repository contents into `html/` (preserve `cache/`, `lib/`, `includes/`, `cron/`).
2. Ensure PHP 8.1+ is active.
3. Protect internals via `.htaccess` (already included): `/lib`, `/cache`, `/cron`, `/includes` are forbidden.
4. Event source:
   - Seeded cache: `cache/events.json` + `cache/events-archive.json`
   - Preferred: copy `lib/upstream-events.example.php` → `lib/upstream-events.php` and implement the Snapticket/Vivenu fetch with server credentials (do not commit secrets).
   - Or set env `BCN_EVENTS_UPSTREAM` to an internal JSON endpoint.
5. Cron (Europe/Berlin), e.g. in KAS:
   - `5 0 * * * php /pfad/zu/html/cron/refresh-events.php`
   - `5 22 * * * php /pfad/zu/html/cron/refresh-events.php`
6. Pages render live in PHP – no daily static HTML rebuild required for correctness. Cron keeps cache/sitemap fresh.
7. Ticket price comes from event data (`minPrice`, currently 20).
