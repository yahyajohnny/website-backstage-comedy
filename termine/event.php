<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$slug = isset($_GET['slug']) ? trim((string) $_GET['slug']) : '';
if ($slug === '' || !preg_match('/^[a-z0-9\-]+$/', $slug)) {
    http_response_code(404);
    header('Location: /termine/', true, 302);
    exit;
}

$now = bcn_now();
$event = bcn_event_by_slug($slug, $now);
if ($event === null) {
    http_response_code(404);
    header('Location: /termine/', true, 302);
    exit;
}

$upcoming = bcn_is_upcoming($event, $now);
$next = bcn_next_event($now);
$images = bcn_local_event_images($event);
$dateLong = bcn_format_date_long($event['startDt']);
$dateShort = bcn_format_date_short($event['startDt']);
$doors = bcn_format_time($event['doorsDt']);
$start = bcn_format_time($event['startDt']);
$priceLabel = bcn_price_label($event['minPrice']);
$ticketMeta = $priceLabel !== 'Tickets im Vorverkauf'
    ? $priceLabel . ' im Vorverkauf'
    : 'Tickets im Vorverkauf';

$metaDesc = 'Backstage Comedy Night am ' . $dateLong . ' im Backstage München: Stand-up Comedy mit mehreren Comedians. Einlass '
    . $doors . ' Uhr, Beginn ' . $start . ' Uhr. ' . $ticketMeta . '.';

$page = [
    'title' => 'Stand-up Comedy München am ' . $dateShort . ' | Backstage Comedy Night',
    'description' => $metaDesc,
    'canonical' => bcn_event_url($event),
    'ogTitle' => 'Stand-up Comedy München am ' . $dateShort . ' | Backstage Comedy Night',
    'ogDescription' => $metaDesc,
    'twitterTitle' => 'Stand-up Comedy München am ' . $dateShort . ' | Backstage Comedy Night',
    'twitterDescription' => $metaDesc,
    'ogImage' => bcn_url($images['16x9']),
    'activeNav' => 'termine',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Termine', 'url' => bcn_url('/termine/')],
            ['name' => $dateShort],
        ]),
        bcn_schema_comedy_event($event, $now),
    ],
];

require dirname(__DIR__) . '/includes/head.php';
?>
<main>
  <div class="page-hero">
    <div class="container">
      <?= bcn_breadcrumb_html([
          ['name' => 'Startseite', 'url' => '/'],
          ['name' => 'Termine', 'url' => '/termine/'],
          ['name' => $dateShort],
      ]) ?>
      <span class="section-label">Comedy Show München</span>
      <h1><?= bcn_esc($event['name']) ?></h1>
      <p><?= bcn_esc($dateLong) ?> · Backstage München</p>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
<?php if (!$upcoming): ?>
      <p><strong>Diese Show hat bereits stattgefunden.</strong></p>
<?php if ($next): ?>
      <p>Der nächste Termin der Backstage Comedy Night ist am <strong><?= bcn_esc(bcn_format_date_long($next['startDt'])) ?></strong>.</p>
      <?= bcn_render_event_list([$next], $now) ?>
<?php else: ?>
      <p>Aktuell sind keine weiteren Termine veröffentlicht. Schau in die <a href="/termine/">Terminübersicht</a>.</p>
<?php endif; ?>
<?php else: ?>
      <div class="event-detail-box">
        <h2>Show-Details</h2>
        <dl class="event-facts">
          <div><dt>Datum</dt><dd><?= bcn_esc($dateLong) ?></dd></div>
          <div><dt>Einlass</dt><dd><?= bcn_esc($doors) ?> Uhr</dd></div>
          <div><dt>Showbeginn</dt><dd><?= bcn_esc($start) ?> Uhr</dd></div>
          <div><dt>Location</dt><dd>Backstage München, <?= bcn_esc(BCN_LOCATION['street']) ?>, <?= bcn_esc(BCN_LOCATION['postal']) ?> <?= bcn_esc(BCN_LOCATION['city']) ?></dd></div>
          <div><dt>Tickets</dt><dd><?= bcn_esc($event['soldOut'] ? 'Ausverkauft' : $ticketMeta) ?></dd></div>
          <div><dt>Sprache</dt><dd>Deutsch</dd></div>
          <div><dt>Mindestalter</dt><dd>18 Jahre (Ausweis mitbringen)</dd></div>
<?php if (!empty($event['lineup'])): ?>
          <div><dt>Line-up</dt><dd><?= bcn_esc(implode(', ', $event['lineup'])) ?></dd></div>
<?php endif; ?>
        </dl>
<?php if ($event['soldOut']): ?>
        <p class="event-soldout-note">Diese Show ist ausverkauft. Schau in unsere <a href="/termine/">Terminübersicht</a> für weitere Daten.</p>
        <a href="/termine/" class="btn btn-primary" style="margin-top:1rem;">Weitere Termine ansehen</a>
<?php else: ?>
        <a href="<?= bcn_esc($event['ticketUrl']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary js-ticket-link" style="margin-top:1rem;"<?= bcn_ticket_attrs($event) ?>>Tickets für den <?= bcn_esc($dateShort) ?> sichern</a>
<?php endif; ?>
      </div>

      <h2 style="margin-top:2.5rem;">Show-Bilder</h2>
      <div class="shows-grid" style="margin-top:1rem;">
        <figure class="show-card" style="margin:0;">
          <div class="show-card-image" style="aspect-ratio:1/1;">
            <img src="<?= bcn_esc($images['1x1']) ?>" alt="Backstage Comedy Night – Poster 1:1, <?= bcn_esc($dateShort) ?>" width="800" height="800" loading="eager">
          </div>
          <figcaption class="show-card-body" style="padding:12px;font-size:0.85rem;color:var(--text-secondary);">1:1</figcaption>
        </figure>
        <figure class="show-card" style="margin:0;">
          <div class="show-card-image" style="aspect-ratio:4/3;">
            <img src="<?= bcn_esc($images['4x3']) ?>" alt="Backstage Comedy Night – Poster 4:3, <?= bcn_esc($dateShort) ?>" width="800" height="600" loading="lazy">
          </div>
          <figcaption class="show-card-body" style="padding:12px;font-size:0.85rem;color:var(--text-secondary);">4:3</figcaption>
        </figure>
        <figure class="show-card" style="margin:0;">
          <div class="show-card-image" style="aspect-ratio:16/9;">
            <img src="<?= bcn_esc($images['16x9']) ?>" alt="Backstage Comedy Night – Poster 16:9, <?= bcn_esc($dateShort) ?>" width="1200" height="675" loading="lazy">
          </div>
          <figcaption class="show-card-body" style="padding:12px;font-size:0.85rem;color:var(--text-secondary);">16:9</figcaption>
        </figure>
      </div>

      <h2 style="margin-top:3rem;">Was dich am <?= bcn_esc($dateShort) ?> erwartet</h2>
      <p>Stand-up Comedy in München, live im Backstage: Auf der Bühne stehen mehrere Comedians mit jeweils eigenem Material – eine kuratierte Mixed Show, kein Open Mic. Die Show dauert rund zwei Stunden inklusive kurzer Pause und ist komplett auf Deutsch.</p>
      <p>Einlass ist um <?= bcn_esc($doors) ?> Uhr – komm rechtzeitig, such dir einen guten Platz und hol dir ein Getränk an der Bar. Um <?= bcn_esc($start) ?> Uhr geht das Licht an.</p>

      <h2>Anfahrt zum Backstage München</h2>
      <p>Das Backstage liegt in der <?= bcn_esc(BCN_LOCATION['street']) ?>, <?= bcn_esc(BCN_LOCATION['postal']) ?> <?= bcn_esc(BCN_LOCATION['city']) ?>. Mit der S-Bahn: Station Hirschgarten (S3/S4/S6/S8), von dort ca. 5 Minuten zu Fuß. Mehr zur Location auf <a href="/backstage-muenchen-comedy/">Comedy im Backstage München</a>.</p>

      <div class="page-cta-row">
<?php if (!$event['soldOut']): ?>
        <a href="<?= bcn_esc($event['ticketUrl']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary js-ticket-link"<?= bcn_ticket_attrs($event) ?>>Tickets sichern</a>
<?php endif; ?>
        <a href="/termine/" class="btn btn-secondary">Alle Termine ansehen</a>
        <a href="/tickets/" class="btn btn-secondary">Ticket-Infos</a>
      </div>
<?php endif; ?>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
