<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

$now = bcn_now();
$next = bcn_next_event($now);

$formSent = false;
$formError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['gname'] ?? ''));
    $email = trim((string) ($_POST['gmail'] ?? ''));
    $date = trim((string) ($_POST['gdate'] ?? ''));
    $size = trim((string) ($_POST['gsize'] ?? ''));
    $occasion = trim((string) ($_POST['ganlass'] ?? ''));
    $message = trim((string) ($_POST['gmsg'] ?? ''));

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = 'Bitte gib einen gültigen Namen und eine gültige E-Mail-Adresse an.';
    } else {
        $subject = 'Gruppenanfrage Backstage Comedy Night';
        $body = "Name: {$name}\n"
            . "E-Mail: {$email}\n"
            . "Wunschtermin: {$date}\n"
            . "Gruppengröße: {$size}\n"
            . "Anlass: {$occasion}\n\n"
            . $message;

        $headers = [
            'From: ' . BCN_EMAIL,
            'Reply-To: ' . $email,
            'Content-Type: text/plain; charset=UTF-8',
        ];

        $sent = @mail(BCN_EMAIL, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, implode("\r\n", $headers));

        if ($sent) {
            $formSent = true;
        } else {
            $formError = 'Die Nachricht konnte nicht versendet werden. Bitte nutze die Mailto-Alternative unten.';
        }
    }
}

$page = [
    'title' => 'Comedy für Gruppen & Firmenevents in München | Backstage Comedy Night',
    'description' => 'Teamabend, Weihnachtsfeier, Geburtstag oder JGA: Die Backstage Comedy Night in München eignet sich für Gruppen. Anfrage für Firmenevents und private Shows.',
    'canonical' => bcn_url('/gruppen-firmenevents/'),
    'activeNav' => 'gruppen',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Gruppen & Firmenevents'],
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
          ['name' => 'Gruppen & Firmenevents'],
      ]) ?>
      <span class="section-label">Gruppen &amp; B2B</span>
      <h1>Comedy für Gruppen, Geburtstage und Firmenevents in München</h1>
      <p>Für Teamabende, Weihnachtsfeiern, Geburtstage, JGAs oder private Shows – schreib uns mit deinem Anlass und wir melden uns zurück.</p>
    </div>
  </div>

  <section class="section">
    <div class="container" style="max-width:860px;">
      <h2>Für wen der Abend passt</h2>
      <p><strong>Geburtstag:</strong> Ein gemeinsamer Comedy-Abend statt der üblichen Restaurant-Reservierung.</p>
      <p><strong>JGA:</strong> Ein Programmpunkt, der zur Gruppe passt – danach liegt das Backstage-Gelände direkt vor der Tür.</p>
      <p><strong>Team- und Firmenabende:</strong> Auch als Weihnachtsfeier oder Jahresabschluss – gemeinsam lachen, ohne Teambuilding-Spiele.</p>
      <p><strong>Private Show:</strong> Für größere Anlässe oder eigene Formate meldet euch bei uns – wir besprechen, was möglich ist.</p>

      <h2>So läuft es ab</h2>
      <p>Für kleinere Gruppen reicht es oft, normale Tickets über den <a href="/tickets/">Vorverkauf</a> zu buchen – am besten früh, damit ihr zusammensitzt. Einlass ist eine Stunde vor Showbeginn.</p>
      <p>Für größere Gruppen, reservierte Plätze, Firmenevents oder Sonderwünsche nutzt das Formular unten – oder schreibt direkt an <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>"><?= bcn_esc(BCN_EMAIL) ?></a>.</p>

      <h2>Der nächste Termin</h2>
<?php if ($next): ?>
      <?= bcn_render_event_list([$next], $now) ?>
<?php else: ?>
      <p>Aktuell sind keine Termine veröffentlicht. Schau in die <a href="/termine/">Terminübersicht</a>.</p>
<?php endif; ?>

      <h2 style="margin-top:3rem;">Gruppenanfrage stellen</h2>
<?php if ($formSent): ?>
      <p><strong>Danke – deine Anfrage wurde gesendet.</strong> Wir melden uns per E-Mail bei dir.</p>
<?php else: ?>
<?php if ($formError !== ''): ?>
      <p style="color:#ff6b6b;"><?= bcn_esc($formError) ?></p>
<?php endif; ?>
      <form class="group-form" method="post" action="">
        <div class="form-row">
          <label>Name<input type="text" name="gname" required value="<?= bcn_esc($_POST['gname'] ?? '') ?>" /></label>
          <label>E-Mail<input type="email" name="gmail" required value="<?= bcn_esc($_POST['gmail'] ?? '') ?>" /></label>
        </div>
        <div class="form-row">
          <label>Wunschtermin<input type="text" name="gdate" placeholder="z. B. nächste Show oder Datum" value="<?= bcn_esc($_POST['gdate'] ?? '') ?>" /></label>
          <label>Gruppengröße<input type="number" name="gsize" min="1" placeholder="z. B. 15" value="<?= bcn_esc($_POST['gsize'] ?? '') ?>" /></label>
        </div>
        <label>Anlass
          <select name="ganlass">
<?php
$occasions = ['Geburtstag', 'JGA', 'Team-/Firmenevent', 'Weihnachtsfeier', 'Private Show', 'Sonstiges'];
$selected = $_POST['ganlass'] ?? 'Team-/Firmenevent';
foreach ($occasions as $occ):
?>
            <option<?= $selected === $occ ? ' selected' : '' ?>><?= bcn_esc($occ) ?></option>
<?php endforeach; ?>
          </select>
        </label>
        <label>Nachricht<textarea name="gmsg" rows="4"><?= bcn_esc($_POST['gmsg'] ?? '') ?></textarea></label>
        <button type="submit" class="btn btn-primary">Anfrage senden</button>
        <p class="form-note">Alternativ per E-Mail: <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>?subject=<?= rawurlencode('Gruppenanfrage Backstage Comedy Night') ?>"><?= bcn_esc(BCN_EMAIL) ?></a></p>
      </form>
<?php endif; ?>

      <div class="page-cta-row">
        <a href="/tickets/" class="btn btn-primary">Tickets im Vorverkauf</a>
        <a href="/termine/" class="btn btn-secondary">Alle Termine</a>
      </div>
    </div>
  </section>
</main>
<?php require dirname(__DIR__) . '/includes/footer.php'; ?>
