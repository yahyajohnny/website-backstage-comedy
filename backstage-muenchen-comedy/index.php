<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$next = bcn_next_event($now);
$upcoming = array_slice(bcn_upcoming_events($now), 0, 3);

$mapEmbed = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.038912345678!2d11.5256!3d48.1444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479e75f0a0e0e0e1%3A0x0!2sBackstage%20M%C3%BCnchen!5e0!3m2!1sde!2sde!4v1700000000000!5m2!1sde!2sde';

$page = [
    'title' => 'Comedy im Backstage München | Backstage Comedy Night',
    'description' => 'Stand-up Comedy im Backstage München: Die Backstage Comedy Night bringt monatlich mehrere Comedians auf die Bühne. Infos zu Location, Anfahrt und Tickets.',
    'canonical' => bcn_url('/backstage-muenchen-comedy/'),
    'activeNav' => 'location',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Backstage München Comedy'],
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
          ['name' => 'Backstage München Comedy'],
      ]) ?>
      <span class="section-label">Location</span>
      <h1>Comedy im Backstage München</h1>
      <p>Das Backstage ist seit Jahrzehnten eine feste Größe im Münchner Nachtleben – und einmal im Monat gehört die Bühne der Stand-up Comedy.</p>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <h2>Stand-up Comedy im Backstage: die Backstage Comedy Night</h2>
      <p>Die Backstage Comedy Night ist die monatliche Stand-up-Show im Backstage München. Mehrere Comedians teilen sich einen Abend – eine kuratierte Mixed Show mit wechselndem Line-up, kein Open Mic.</p>
      <p>Club-Charakter statt Theaterbestuhlung, die Bühne nah am Publikum, Getränke an der Bar – passend für Live Comedy in München.</p>

      <h2>Anfahrt: So kommst du hin</h2>
      <dl class="event-facts">
        <div><dt>Adresse</dt><dd><?= bcn_esc(BCN_LOCATION['name']) ?>, <?= bcn_esc(BCN_LOCATION['street']) ?>, <?= bcn_esc(BCN_LOCATION['postal']) ?> <?= bcn_esc(BCN_LOCATION['city']) ?></dd></div>
        <div><dt>S-Bahn</dt><dd>Station Hirschgarten (S3/S4/S6/S8), ca. 5 Minuten Fußweg</dd></div>
        <div><dt>Tram</dt><dd>Linien 16/17, Haltestelle Steubenplatz</dd></div>
        <div><dt>Auto</dt><dd>Parkplätze direkt auf dem Backstage-Gelände</dd></div>
        <div><dt>Barrierefreiheit</dt><dd>Das Backstage ist barrierefrei zugänglich</dd></div>
      </dl>

      <h2>Karte</h2>
      <div class="location-map-wrap" id="bcn-map-wrap">
        <button type="button" class="btn btn-secondary" id="bcn-map-load" style="width:100%;padding:2rem;">Karte laden (Google Maps)</button>
      </div>
      <p class="map-privacy">Beim Laden der Karte wird eine Verbindung zu Google hergestellt. Mehr dazu in der <a href="/datenschutz.php">Datenschutzerklärung</a>.</p>

      <h2 style="margin-top:3rem;">So läuft der Abend ab</h2>
      <p>Einlass ist eine Stunde vor Showbeginn. Wer früh kommt, sichert sich gute Plätze und hat Zeit für ein Getränk. Die Show dauert rund zwei Stunden inklusive kurzer Pause. Danach kann der Abend auf dem Backstage-Gelände weitergehen.</p>
      <p>Die Show ist ab 18 Jahren und komplett auf Deutsch.</p>

      <h2>Der nächste Comedy-Termin im Backstage</h2>
      <?= bcn_render_event_list($upcoming ?: ($next ? [$next] : []), $now) ?>

      <div class="page-cta-row">
        <a href="/tickets/" class="btn btn-primary">Tickets sichern</a>
        <a href="/termine/" class="btn btn-secondary">Alle Termine ansehen</a>
        <a href="/galerie.php" class="btn btn-secondary">Fotos aus dem Backstage</a>
      </div>
    </div>
  </section>
</main>
<script>
(function () {
  var btn = document.getElementById('bcn-map-load');
  var wrap = document.getElementById('bcn-map-wrap');
  if (!btn || !wrap) return;
  btn.addEventListener('click', function () {
    wrap.innerHTML = '<iframe loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Backstage München auf Google Maps" src="<?= bcn_esc($mapEmbed) ?>" width="100%" height="420" style="border:0;" allowfullscreen></iframe>';
  });
})();
</script>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
