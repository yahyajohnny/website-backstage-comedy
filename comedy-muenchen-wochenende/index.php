<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$weekendWindow = bcn_next_weekend_window_events($now);
$weekendAll = bcn_weekend_events($now);
$next = bcn_next_event($now);

if (!$weekendWindow && $weekendAll) {
    $fallbackWeekend = [$weekendAll[0]];
} else {
    $fallbackWeekend = [];
}

$page = [
    'title' => 'Comedy München Wochenende | Stand-up Shows im Backstage',
    'description' => 'Du suchst Comedy in München am Wochenende? Hier findest du Termine der Backstage Comedy Night, die auf Freitag, Samstag oder Sonntag fallen.',
    'canonical' => bcn_url('/comedy-muenchen-wochenende/'),
    'activeNav' => '',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Comedy München Wochenende'],
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
          ['name' => 'Comedy München Wochenende'],
      ]) ?>
      <span class="section-label">Wochenende</span>
      <h1>Comedy in München am Wochenende</h1>
      <p>Stand-up Comedy statt immer derselben Bar: Hier findest du Termine der Backstage Comedy Night, die aufs Wochenende (Freitag bis Sonntag) fallen.</p>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <h2>Termine am kommenden Wochenende</h2>
<?php if ($weekendWindow): ?>
      <?= bcn_render_event_list($weekendWindow, $now) ?>
<?php else: ?>
      <p>In dem kommenden Wochenend-Zeitraum findet keine Backstage Comedy Night statt.</p>
<?php if ($fallbackWeekend): ?>
      <h2 style="margin-top:2rem;">Nächster Wochenend-Termin</h2>
      <?= bcn_render_event_list($fallbackWeekend, $now) ?>
<?php elseif ($next): ?>
      <h2 style="margin-top:2rem;">Nächster Termin</h2>
      <?= bcn_render_event_list([$next], $now) ?>
<?php endif; ?>
<?php endif; ?>

      <p>Die Backstage Comedy Night findet nicht jedes Wochenende statt, sondern einmal im Monat – manchmal unter der Woche, manchmal am Wochenende. Alle Termine findest du in der <a href="/termine/">Terminübersicht</a>.</p>

      <div class="page-cta-row">
        <?= bcn_next_ticket_cta($next) ?>
        <a href="/termine/" class="btn btn-secondary">Alle Termine ansehen</a>
        <a href="/comedy-muenchen-heute/" class="btn btn-secondary">Comedy heute</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
