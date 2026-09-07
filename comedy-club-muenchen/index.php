<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$next = bcn_next_event($now);

$page = [
    'title' => 'Comedy Club München | Stand-up im Backstage',
    'description' => 'Die Backstage Comedy Night ist keine tägliche Comedy-Bar, sondern eine monatlich stattfindende kuratierte Mixed Show im Backstage München.',
    'canonical' => bcn_url('/comedy-club-muenchen/'),
    'activeNav' => '',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Comedy Club München'],
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
          ['name' => 'Comedy Club München'],
      ]) ?>
      <span class="section-label">Comedy Club</span>
      <h1>Comedy Club München – Stand-up im Backstage</h1>
      <p>Die Backstage Comedy Night ist keine tägliche Comedy-Bar, sondern eine monatlich stattfindende Stand-up-Show im Backstage Club – kuratiert, mit wechselndem Line-up.</p>
      <?= bcn_next_ticket_cta($next) ?>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <p>Wer nach „Comedy Club München" sucht, meint oft einen Ort mit regelmäßigem Live-Programm. Genau das bieten wir – allerdings nicht jeden Abend, sondern einmal im Monat als <strong>Backstage Comedy Night</strong>.</p>

      <h2>Kein täglicher Comedy-Abend – bewusst monatlich</h2>
      <p>Wir sind keine Comedy-Bar mit Open-Mic jeden Dienstag. Stattdessen kuratieren wir einmal im Monat eine Mixed Show: mehrere Stand-up-Comedians, ein Abend, Club-Atmosphäre im Backstage München. Qualität vor Masse.</p>

      <h2>Der Club: Backstage München</h2>
      <p>Das Backstage in der Reitknechtstraße ist einer der bekanntesten Veranstaltungsorte Münchens. Für die Comedy Night nutzen wir die Club-Atmosphäre: dunkler Raum, Bühne, Nähe zum Publikum. Details zur Anfahrt: <a href="/backstage-muenchen-comedy/">Comedy im Backstage</a>.</p>

      <h2>Programm</h2>
      <p>Einmal im Monat treten mehrere Comedians auf – eine Mixed Comedy Show auf Deutsch, ab 18 Jahren, rund zwei Stunden inklusive Pause. Das Line-up wechselt von Termin zu Termin.</p>

      <h2>Nächster Termin</h2>
<?php if ($next): ?>
      <?= bcn_render_event_list([$next], $now) ?>
<?php else: ?>
      <p>Aktuell sind keine Termine veröffentlicht. Schau in die <a href="/termine/">Terminübersicht</a>.</p>
<?php endif; ?>

      <div class="page-cta-row">
        <a href="/termine/" class="btn btn-primary">Termine &amp; Tickets</a>
        <a href="/stand-up-comedy-muenchen/" class="btn btn-secondary">Stand-up Comedy München</a>
        <a href="/gruppen-firmenevents/" class="btn btn-secondary">Firmenevents</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
