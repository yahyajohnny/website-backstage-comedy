<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$upcoming = bcn_upcoming_events($now);
$next = bcn_next_event($now);

$page = [
    'title' => 'Comedy Shows München Termine | Backstage Comedy Night',
    'description' => 'Alle kommenden Termine der Backstage Comedy Night in München: Stand-up Comedy live im Backstage mit wechselndem Line-up.',
    'canonical' => bcn_url('/termine/'),
    'activeNav' => 'termine',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Termine'],
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
          ['name' => 'Termine'],
      ]) ?>
      <span class="section-label">Termine</span>
      <h1>Comedy Shows in München – alle Termine der Backstage Comedy Night</h1>
      <p>Hier findest du alle kommenden Shows. Die Backstage Comedy Night findet einmal im Monat im Backstage München statt – Einlass ist jeweils eine Stunde vor Showbeginn.</p>
<?php if ($next): ?>
      <p style="margin-top:1rem;">Nächster Termin: <a href="<?= bcn_esc(bcn_event_path($next)) ?>"><?= bcn_esc(bcn_format_date_long($next['startDt'])) ?></a></p>
<?php endif; ?>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <div class="shows-grid">
        <?= bcn_render_show_grid($upcoming, $now) ?>
      </div>

      <div class="page-cta-row">
        <a href="/tickets/" class="btn btn-primary">Alles rund um Tickets</a>
        <a href="/backstage-muenchen-comedy/" class="btn btn-secondary">Zur Location: Backstage München</a>
<?php if ($next): ?>
        <a href="<?= bcn_esc(bcn_event_path($next)) ?>" class="btn btn-secondary">Nächste Show im Detail</a>
<?php endif; ?>
      </div>

      <h2 style="margin-top:3.5rem;">So läuft ein Abend bei der Backstage Comedy Night ab</h2>
      <p>Einlass ist eine Stunde vor Showbeginn – genug Zeit, um sich einen guten Platz zu sichern und ein Getränk an der Bar zu holen. Die Show selbst dauert rund zwei Stunden inklusive kurzer Pause. Auf der Bühne stehen mehrere Stand-up-Comedians mit jeweils eigenem Material. Das Line-up wechselt jeden Monat.</p>
      <p>Die Show ist komplett auf Deutsch und ab 18 Jahren. Tickets gibt es im Vorverkauf – Details und Buchung auf der <a href="/tickets/">Ticket-Seite</a>.</p>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
