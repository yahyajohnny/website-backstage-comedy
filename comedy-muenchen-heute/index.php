<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$todayEvents = bcn_events_today($now);
$next = bcn_next_event($now);
$hasShowToday = count($todayEvents) > 0;

$page = [
    'title' => 'Comedy München heute | Nächste Stand-up Show im Backstage',
    'description' => 'Finde heraus, ob heute eine Backstage Comedy Night stattfindet – und wenn nicht, wann der nächste Termin im Backstage München ist.',
    'canonical' => bcn_url('/comedy-muenchen-heute/'),
    'activeNav' => '',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Comedy München heute'],
        ]),
    ],
];

require dirname(__DIR__) . '/includes/head.php';
?>
<main>
  <div class="page-hero">
    <div class="container">
      <?= bcn_breadcrumb_html([
          ['name' => 'Startseite', 'url' => '/'],
          ['name' => 'Comedy München heute'],
      ]) ?>
      <span class="section-label">Heute Abend</span>
      <h1>Comedy in München heute</h1>
<?php if ($hasShowToday): ?>
<?php $today = $todayEvents[0]; ?>
      <p>Heute findet die Backstage Comedy Night statt – <?= bcn_esc(bcn_format_date_long($today['startDt'])) ?>, Einlass <?= bcn_esc(bcn_format_time($today['doorsDt'])) ?> Uhr, Beginn <?= bcn_esc(bcn_format_time($today['startDt'])) ?> Uhr im Backstage München.</p>
<?php else: ?>
      <p>Heute findet keine Backstage Comedy Night statt.<?php if ($next): ?> Der nächste Termin ist am <strong><?= bcn_esc(bcn_format_date_long($next['startDt'])) ?></strong>.<?php endif; ?></p>
<?php endif; ?>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
<?php if ($hasShowToday): ?>
      <h2>Heute im Backstage</h2>
      <?= bcn_render_event_list($todayEvents, $now) ?>
<?php elseif ($next): ?>
      <h2>Der nächste Termin</h2>
      <?= bcn_render_event_list([$next], $now) ?>
<?php endif; ?>

      <p>Die Backstage Comedy Night findet einmal im Monat im Backstage München statt: Stand-up Comedy mit mehreren Comedians und wechselndem Line-up. Alle Termine findest du in der <a href="/termine/">Terminübersicht</a>, Tickets auf der <a href="/tickets/">Ticket-Seite</a>.</p>

      <div class="page-cta-row">
<?php if ($hasShowToday && !$todayEvents[0]['soldOut']): ?>
        <a href="<?= bcn_esc($todayEvents[0]['ticketUrl']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary js-ticket-link"<?= bcn_ticket_attrs($todayEvents[0]) ?>>Tickets für heute sichern</a>
<?php elseif ($next && !$next['soldOut']): ?>
        <?= bcn_next_ticket_cta($next) ?>
<?php endif; ?>
        <a href="/termine/" class="btn btn-secondary">Alle Termine ansehen</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
