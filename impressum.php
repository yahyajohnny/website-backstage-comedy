<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/render.php';

$page = [
    'title' => 'Impressum | Backstage Comedy Night München',
    'description' => 'Impressum der Backstage Comedy Night München – Angaben gemäß § 5 TMG.',
    'canonical' => bcn_url('/impressum.php'),
    'robots' => 'noindex, follow',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Impressum'],
        ]),
    ],
];

require __DIR__ . '/includes/head.php';
?>
<main>
  <div class="inner-hero">
    <div class="container">
      <span class="section-label">Rechtliches</span>
      <h1>Impressum</h1>
    </div>
  </div>

  <div class="container">
    <div class="prose">
      <p>Angaben gemäß § 5 TMG</p>

      <h2>Verantwortlicher</h2>
      <p>
        Yahya Pervaiz<br />
        Drosselstr. 2<br />
        85405 Nandlstadt
      </p>

      <h2>Kontakt</h2>
      <p>
        E-Mail: <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>"><?= bcn_esc(BCN_EMAIL) ?></a>
      </p>

      <h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
      <p>
        Yahya Pervaiz<br />
        Drosselstr. 2<br />
        85405 Nandlstadt
      </p>

      <h2>Haftungsausschluss</h2>

      <h3>Haftung für Inhalte</h3>
      <p>
        Als Diensteanbieter sind wir gemäß § 7 Abs. 1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.
      </p>
      <p>
        Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.
      </p>

      <h3>Haftung für Links</h3>
      <p>
        Unser Angebot enthält Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.
      </p>
      <p>
        Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.
      </p>

      <h3>Urheberrecht</h3>
      <p>
        Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers.
      </p>
    </div>
  </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
