<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/render.php';

$page = [
    'title' => 'Datenschutzerklärung | Backstage Comedy Night München',
    'description' => 'Datenschutzerklärung der Backstage Comedy Night München gemäß DSGVO.',
    'canonical' => bcn_url('/datenschutz.php'),
    'robots' => 'noindex, follow',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Datenschutz'],
        ]),
    ],
];

require __DIR__ . '/includes/head.php';
?>
<main>
  <div class="inner-hero">
    <div class="container">
      <span class="section-label">Rechtliches</span>
      <h1>Datenschutzerklärung</h1>
    </div>
  </div>

  <div class="container">
    <div class="prose">

      <h2>1. Verantwortlicher</h2>
      <p>
        Yahya Pervaiz<br />
        Drosselstr. 2<br />
        85405 Nandlstadt<br />
        E-Mail: <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>"><?= bcn_esc(BCN_EMAIL) ?></a>
      </p>

      <h2>2. Erhebung und Verarbeitung personenbezogener Daten</h2>
      <p>
        Beim Besuch dieser Website werden personenbezogene Daten nur verarbeitet, soweit das technisch erforderlich ist oder Sie uns aktiv kontaktieren (z. B. per Formular oder E-Mail). Tracking erfolgt nur nach Ihrer Einwilligung über Matomo (siehe unten).
      </p>

      <h2>3. Hosting</h2>
      <p>
        Diese Website wird gehostet von:<br />
        <strong>ALL-INKL.COM – Neue Medien Münnich</strong><br />
        Hauptstraße 68 · 02742 Friedersdorf · Deutschland
      </p>
      <p>
        Beim Aufruf unserer Website werden durch den Hosting-Anbieter automatisch sog. Server-Log-Dateien erhoben. Diese enthalten:
      </p>
      <ul>
        <li>IP-Adresse des anfragenden Rechners</li>
        <li>Datum und Uhrzeit des Zugriffs</li>
        <li>Name der abgerufenen Datei</li>
        <li>Website, von der aus der Zugriff erfolgte (Referrer)</li>
        <li>verwendeter Browser und Betriebssystem</li>
      </ul>
      <p>
        Diese Daten werden ausschließlich zur Sicherstellung eines störungsfreien Betriebs der Website verwendet. Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse). Die Daten werden nach spätestens 7 Tagen gelöscht.
      </p>

      <h2>4. Cookies</h2>
      <p>
        Diese Website setzt keine Marketing-Cookies. Matomo wird erst nach Ihrer Einwilligung im Cookie-Banner geladen. Zusätzlich kann sessionStorage im Browser genutzt werden (z. B. einmalige Anzeige eines Lade-Screens) – diese Daten verlassen nicht Ihr Gerät.
      </p>

      <h2>5. Schriftarten</h2>
      <p>
        Die Schrift „Outfit" wird lokal auf unserem Webserver eingebunden (<code>/assets/fonts/outfit.css</code>). Beim Seitenaufruf werden dafür keine Verbindungen zu Google-Servern hergestellt.
      </p>

      <h2>6. Google Maps</h2>
      <p>
        Auf einzelnen Seiten (z. B. Location) kann eine interaktive Google Maps-Karte eingebunden werden. Die Karte wird erst geladen, wenn Sie aktiv auf „Karte laden" klicken. Dabei wird eine Verbindung zu Google hergestellt; dabei kann u. a. Ihre IP-Adresse an Google übertragen werden.
      </p>
      <p>
        Anbieter: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA.<br />
        Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">https://policies.google.com/privacy</a>
      </p>
      <p>
        Rechtsgrundlage: Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse an der Standortdarstellung), sofern Sie die Karte aktiv laden.
      </p>

      <h2>7. Ticketverkauf über Snapticket</h2>
      <p>
        Der Ticketverkauf erfolgt über Snapticket (<a href="https://shop.snapticket.de/" target="_blank" rel="noopener noreferrer">shop.snapticket.de</a>). Beim Klick auf einen Ticket-Link werden Sie auf die externe Ticketseite weitergeleitet. Für die Datenverarbeitung beim Ticketkauf ist der Betreiber von Snapticket verantwortlich. Bitte lesen Sie die Datenschutzerklärung von Snapticket: <a href="https://snapticket.de/datenschutz" target="_blank" rel="noopener noreferrer">snapticket.de/datenschutz</a>.
      </p>

      <h2>8. Kontaktaufnahme per E-Mail oder Formular</h2>
      <p>
        Wenn Sie uns per E-Mail oder über das Gruppenformular kontaktieren, werden Ihre Angaben zur Bearbeitung Ihrer Anfrage gespeichert. Eine Weitergabe an Dritte erfolgt nicht, sofern nicht gesetzlich erforderlich. Rechtsgrundlage: Art. 6 Abs. 1 lit. b DSGVO (Vertragserfüllung/vorvertragliche Maßnahmen) bzw. Art. 6 Abs. 1 lit. f DSGVO (berechtigtes Interesse). Die Daten werden gelöscht, sobald die Anfrage abschließend beantwortet ist und kein Aufbewahrungsgebot entgegensteht.
      </p>

      <h2>9. Bildrechte</h2>
      <p>
        Fotos auf dieser Website sind eigene Aufnahmen oder wurden mit Genehmigung der abgebildeten Personen verwendet. Urheberrechte liegen bei den Erstellern.
      </p>

      <h2>10. Analytics – Matomo</h2>
      <p>
        Diese Website nutzt <strong>Matomo</strong>, ein Web-Analyse-Tool auf eigenem Server (<code>matomo.yahyapervaiz.com</code>). Matomo wird <strong>nur nach Ihrer Einwilligung</strong> im Cookie-Banner geladen – ohne Zustimmung findet kein Tracking statt.
      </p>
      <p>
        Beim Einsatz von Matomo können u. a. anonymisierte IP-Adresse, aufgerufene Seite, Herkunfts-URL, Browsertyp, Datum und Uhrzeit verarbeitet werden. Rechtsgrundlage: Art. 6 Abs. 1 lit. a DSGVO (Einwilligung). Sie können Ihre Einwilligung jederzeit widerrufen, indem Sie die Seite neu laden und im Cookie-Banner „Nur notwendige" wählen.
      </p>

      <h2>11. Ihre Rechte als betroffene Person</h2>
      <p>Sie haben nach der DSGVO folgende Rechte gegenüber uns:</p>
      <ul>
        <li><strong>Recht auf Auskunft</strong> (Art. 15 DSGVO)</li>
        <li><strong>Recht auf Berichtigung</strong> (Art. 16 DSGVO)</li>
        <li><strong>Recht auf Löschung</strong> (Art. 17 DSGVO)</li>
        <li><strong>Recht auf Einschränkung der Verarbeitung</strong> (Art. 18 DSGVO)</li>
        <li><strong>Recht auf Widerspruch</strong> (Art. 21 DSGVO)</li>
        <li><strong>Recht auf Datenübertragbarkeit</strong> (Art. 20 DSGVO)</li>
        <li><strong>Beschwerderecht bei einer Aufsichtsbehörde</strong></li>
      </ul>
      <p>
        Zur Ausübung Ihrer Rechte wenden Sie sich bitte an: <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>"><?= bcn_esc(BCN_EMAIL) ?></a>
      </p>

      <h2>12. Aktualität dieser Datenschutzerklärung</h2>
      <p>
        Diese Datenschutzerklärung hat den Stand September 2026. Durch die Weiterentwicklung unserer Website oder aufgrund geänderter gesetzlicher bzw. behördlicher Vorgaben kann es notwendig werden, diese Datenschutzerklärung zu ändern.
      </p>

    </div>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
