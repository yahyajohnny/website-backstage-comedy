<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$next = bcn_next_event($now);
$upcoming = bcn_upcoming_events($now);
$priceLabel = $next ? bcn_price_label($next['minPrice']) : 'Tickets im Vorverkauf';

$faqs = [
    [
        'q' => 'Wo kaufe ich Comedy Tickets für München?',
        'a' => 'Tickets für die Backstage Comedy Night gibt es online über Snapticket (shop.snapticket.de). Termin in der Terminübersicht auswählen, buchen – das Ticket kommt per E-Mail.',
    ],
    [
        'q' => 'Was kosten die Tickets?',
        'a' => $priceLabel !== 'Tickets im Vorverkauf'
            ? 'Tickets gibt es ' . $priceLabel . ' im Vorverkauf. Dafür bekommst du rund zwei Stunden Stand-up Comedy mit mehreren Comedians.'
            : 'Tickets gibt es im Vorverkauf. Dafür bekommst du rund zwei Stunden Stand-up Comedy mit mehreren Comedians.',
    ],
    [
        'q' => 'Gibt es eine Abendkasse?',
        'a' => 'Wenn die Show nicht ausverkauft ist, ja. Verlass dich aber nicht darauf – viele Termine sind im Vorverkauf weg.',
    ],
    [
        'q' => 'Sind die Tickets digital?',
        'a' => 'Ja. Nach dem Kauf bekommst du dein Ticket per E-Mail und zeigst es am Einlass einfach auf dem Handy vor.',
    ],
    [
        'q' => 'Kann ich Tickets weitergeben?',
        'a' => 'Ja, die Tickets sind übertragbar. Wenn du verhindert bist, kann jemand anderes mit deinem Ticket rein.',
    ],
    [
        'q' => 'Was ist, wenn die Show ausverkauft ist?',
        'a' => 'Dann lohnt sich ein Blick auf die nächsten Termine – die Show findet regelmäßig statt. Folge uns auf Instagram, dort kündigen wir neue Termine an.',
    ],
    [
        'q' => 'Gibt es Gruppentickets?',
        'a' => 'Für größere Gruppen, Geburtstage oder Firmenevents schreib uns direkt – wir finden eine Lösung. Alle Infos auf der Seite für Gruppen & Firmenevents.',
    ],
];

$page = [
    'title' => 'Comedy Tickets München | Backstage Comedy Night im Backstage',
    'description' => 'Sichere dir Tickets für die Backstage Comedy Night in München. Stand-up Comedy live im Backstage, monatliche Termine und Vorverkauf über Snapticket.',
    'canonical' => bcn_url('/tickets/'),
    'activeNav' => 'tickets',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Tickets'],
        ]),
        bcn_schema_faq($faqs),
    ],
];

require dirname(__DIR__) . '/includes/head.php';
?>
<main>
  <div class="page-hero">
    <div class="container">
      <?= bcn_breadcrumb_html([
          ['name' => 'Startseite', 'url' => '/'],
          ['name' => 'Tickets'],
      ]) ?>
      <span class="section-label">Tickets</span>
      <h1>Comedy Tickets für München</h1>
      <p>Tickets für die Backstage Comedy Night gibt es im Vorverkauf über Snapticket – digital, übertragbar und in wenigen Klicks gebucht.</p>
      <?= bcn_next_ticket_cta($next) ?>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <h2>Kommende Termine</h2>
      <?= bcn_render_event_list(array_slice($upcoming, 0, 3), $now) ?>

      <h2 style="margin-top:3rem;">So funktioniert der Ticketkauf</h2>
      <p>Du wählst deinen Termin in der <a href="/termine/">Terminübersicht</a>, klickst auf „Tickets sichern" und buchst im Snapticket-Shop. Dein Ticket kommt per E-Mail – ausdrucken musst du nichts, das Handy reicht am Einlass.</p>
      <p>Ein Ticket kostet <?= bcn_esc($priceLabel !== 'Tickets im Vorverkauf' ? $priceLabel : 'im Vorverkauf') ?>. Dafür bekommst du rund zwei Stunden Stand-up Comedy mit mehreren Comedians im Backstage München. Einlass ist eine Stunde vor Showbeginn.</p>

      <h2 style="margin-top:3rem;">Häufige Fragen zu Tickets</h2>
      <div class="faq-list" role="list">
<?php foreach ($faqs as $faq): ?>
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
        <?= bcn_next_ticket_cta($next) ?>
        <a href="/termine/" class="btn btn-secondary">Alle Termine ansehen</a>
        <a href="/gruppen-firmenevents/" class="btn btn-secondary">Gruppenanfrage stellen</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
