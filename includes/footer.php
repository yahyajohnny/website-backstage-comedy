<?php
declare(strict_types=1);
$year = (int) bcn_now()->format('Y');
?>
  <footer class="footer" aria-label="Footer">
    <div class="container">
      <div class="footer-inner">
        <a href="/" class="footer-logo" aria-label="Backstage Comedy Night – Startseite">
          <img src="/assets/logo.png" alt="Backstage Comedy Night" width="100" height="28" />
        </a>
        <p class="footer-center">
          © <?= $year ?> Backstage Comedy Night
        </p>
        <nav class="footer-links" aria-label="Footer-Navigation">
          <a href="/termine/">Termine</a>
          <a href="/tickets/">Tickets</a>
          <a href="/stand-up-comedy-muenchen/">Stand-up</a>
          <a href="/comedy-club-muenchen/">Comedy Club</a>
          <a href="/comedy-muenchen-heute/">Comedy heute</a>
          <a href="/gruppen-firmenevents/">Gruppen</a>
          <a href="/galerie.html">Galerie</a>
          <a href="/impressum.html">Impressum</a>
          <a href="/datenschutz.html">Datenschutz</a>
        </nav>
      </div>
    </div>
  </footer>
<?php require __DIR__ . '/matomo-consent.php'; ?>
  <script src="<?= bcn_esc(bcn_asset('/main.js')) ?>" defer></script>
</body>
</html>
