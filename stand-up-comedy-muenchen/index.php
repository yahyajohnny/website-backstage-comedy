<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$next = bcn_next_event($now);
$upcoming = array_slice(bcn_upcoming_events($now), 0, 3);
$priceLabel = $next ? bcn_price_label($next['minPrice']) : 'Tickets im Vorverkauf';

$standupFaqs = [
    [
        'q' => 'Was ist Stand-up Comedy?',
        'a' => 'Stand-up Comedy ist Live-Unterhaltung: Ein Comedian steht allein auf der Bühne und erzählt eigenes Material – Beobachtungen, Geschichten, Pointen. Kein Skript von außen, kein Publikum auf der Bühne.',
    ],
    [
        'q' => 'Was ist der Unterschied zwischen Mixed Show, Open Mic und Solo?',
        'a' => 'Bei einer Mixed Show treten mehrere Comedians nacheinander auf – so läuft die Backstage Comedy Night. Beim Open Mic testen oft Newcomer kurze Sets. Bei einer Solo-Show steht ein Headliner allein auf der Bühne. Wir sind eine kuratierte Mixed Show.',
    ],
    [
        'q' => 'Auf welcher Sprache und für welches Alter?',
        'a' => 'Die Backstage Comedy Night ist komplett auf Deutsch und ab 18 Jahren. Bitte Ausweis mitbringen.',
    ],
    [
        'q' => 'Wie lange dauert die Show?',
        'a' => 'Rund zwei Stunden inklusive kurzer Pause. Einlass ist eine Stunde vor Showbeginn.',
    ],
];

$page = [
    'title' => 'Stand-up Comedy München | Live Shows im Backstage',
    'description' => 'Stand-up Comedy in München live erleben: monatliche Comedy Shows im Backstage mit mehreren Comedians. Termine, Tickets und Infos zur Location.',
    'canonical' => bcn_url('/stand-up-comedy-muenchen/'),
    'activeNav' => 'standup',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Stand-up Comedy München'],
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
          ['name' => 'Stand-up Comedy München'],
      ]) ?>
      <span class="section-label">Stand-up Comedy</span>
      <h1>Stand-up Comedy München – live, deutsch, im Backstage</h1>
      <p>Die Backstage Comedy Night ist die monatliche Stand-up Show im Backstage – mehrere Comedians, ein Abend<?= $priceLabel !== 'Tickets im Vorverkauf' ? ', ' . bcn_esc($priceLabel) : '' ?>.</p>
      <?= bcn_next_ticket_cta($next) ?>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <h2>Was ist Stand-up Comedy?</h2>
      <p>Stand-up Comedy ist Live-Komödie auf der Bühne: Comedians erzählen eigenes Material direkt ans Publikum – ohne Kostüm, ohne Playback. Bei uns läuft das als <strong>Mixed Show</strong>: mehrere Acts hintereinander, verschiedene Stile, eine Pause, rund zwei Stunden Programm.</p>

      <h2>Mixed Show, Open Mic oder Solo?</h2>
      <ul>
        <li><strong>Mixed Show</strong> (unser Format): mehrere Comedians, kuratiertes Programm, wechselndes Line-up.</li>
        <li><strong>Open Mic</strong>: offene Bühne, oft kurze Test-Slots für Newcomer – bei uns nicht das Format.</li>
        <li><strong>Solo</strong>: ein Comedian füllt den Abend allein – bei uns geht es um Vielfalt statt einen einzelnen Headliner.</li>
      </ul>

      <h2>Sprache, Dauer, Alter</h2>
      <p>Die Show ist komplett auf Deutsch, dauert rund zwei Stunden inklusive Pause und richtet sich an Erwachsene ab 18 Jahren (Ausweis mitbringen). Einlass ist jeweils eine Stunde vor Showbeginn.</p>

      <h2>Atmosphäre im Backstage</h2>
      <p>Das Backstage in der Reitknechtstraße ist ein etablierter Club in München: dunkler Saal, Bühne nah am Publikum, Bar vor Ort. Kein Theater mit festen Sitzplätzen, sondern Club-Feeling – passend für Stand-up. Mehr zur Location: <a href="/backstage-muenchen-comedy/">Comedy im Backstage München</a>.</p>

      <h2>Nächste Termine</h2>
      <?= bcn_render_event_list($upcoming ?: ($next ? [$next] : []), $now) ?>

<?php if ($next && !empty($next['lineup'])): ?>
      <h2 style="margin-top:3rem;">Line-up beim nächsten Termin</h2>
      <p><?= bcn_esc(implode(', ', $next['lineup'])) ?></p>
<?php endif; ?>

      <h2 style="margin-top:3rem;">Anfahrt</h2>
      <p>Backstage München, <?= bcn_esc(BCN_LOCATION['street']) ?>, <?= bcn_esc(BCN_LOCATION['postal']) ?> <?= bcn_esc(BCN_LOCATION['city']) ?>. S-Bahn Hirschgarten (S3/S4/S6/S8), ca. 5 Minuten zu Fuß. Parkplätze auf dem Backstage-Gelände.</p>

      <h2 style="margin-top:3rem;">Häufige Fragen</h2>
      <div class="faq-list" role="list">
<?php foreach ($standupFaqs as $faq): ?>
        <div class="faq-item" role="listitem">
          <button class="faq-question" type="button" aria-expanded="false">
            <?= bcn_esc($faq['q']) ?>
            <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          </button>
          <div class="faq-answer" role="region"><p><?= bcn_esc($faq['a']) ?></p></div>
        </div>
<?php endforeach; ?>
      </div>

      <div class="page-cta-row">
        <a href="/termine/" class="btn btn-primary">Alle Termine</a>
<?php if ($next): ?>
        <a href="<?= bcn_esc(bcn_event_path($next)) ?>" class="btn btn-secondary">Nächste Show im Detail</a>
<?php endif; ?>
        <a href="/tickets/" class="btn btn-secondary">Tickets</a>
        <a href="/backstage-muenchen-comedy/" class="btn btn-secondary">Location</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
