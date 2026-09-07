<?php
declare(strict_types=1);
?>
  <div id="cookie-banner" class="cookie-banner" hidden role="dialog" aria-labelledby="cookie-title" aria-describedby="cookie-desc">
    <div class="cookie-banner-inner">
      <div class="cookie-copy">
        <strong id="cookie-title">Cookies &amp; Statistik</strong>
        <p id="cookie-desc">
          Nicht die leckeren – leider. Wir nutzen <strong>Matomo</strong>, um zu sehen, ob jemand außer unseren Müttern diese Seite besucht.
          Matomo läuft auf eigenem Server, ohne Tracking vor deiner Einwilligung.
          Mehr in der <a href="/datenschutz.html">Datenschutzerklärung</a>.
        </p>
      </div>
      <div class="cookie-actions">
        <button type="button" class="btn btn-secondary" id="cookie-decline">Nur notwendige</button>
        <button type="button" class="btn btn-primary" id="cookie-accept">Alles klar</button>
      </div>
    </div>
  </div>
  <script>
  window.BCN_MATOMO = {
    url: <?= json_encode(BCN_MATOMO_URL, JSON_UNESCAPED_SLASHES) ?>,
    siteId: <?= json_encode(BCN_MATOMO_SITE_ID) ?>
  };
  </script>
