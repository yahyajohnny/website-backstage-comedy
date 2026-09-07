<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/render.php';

$now = bcn_now();
$upcoming = bcn_upcoming_events($now);
$next = bcn_next_event($now);

$mapEmbed = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2662.038912345678!2d11.5256!3d48.1444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479e75f0a0e0e0e1%3A0x0!2sBackstage%20M%C3%BCnchen!5e0!3m2!1sde!2sde!4v1700000000000!5m2!1sde!2sde';

$priceLabel = $next ? bcn_price_label($next['minPrice']) : 'Tickets im Vorverkauf';
$ticketAudienceText = ($next && $next['minPrice'] !== null)
    ? 'Tickets gibt es ' . bcn_price_label($next['minPrice']) . ' im Vorverkauf über Snapticket.'
    : 'Tickets im Vorverkauf über Snapticket.';

$homeFaqs = [
    [
        'q' => 'In welcher Sprache ist die Backstage Comedy Night?',
        'a' => 'Die Show ist komplett auf Deutsch. Alle Comedians kommen aus der deutschen und deutschsprachigen Stand-up-Szene.',
    ],
    [
        'q' => 'Wie lange dauert die Comedy Show?',
        'a' => 'Ca. 2 Stunden inklusive einer kurzen Pause.',
    ],
    [
        'q' => 'Gibt es ein Mindestalter für die Backstage Comedy Night?',
        'a' => 'Die Show ist ab 18 Jahren. Bitte bring einen gültigen Lichtbildausweis mit.',
    ],
    [
        'q' => 'Wo kaufe ich Tickets für die Backstage Comedy Night?',
        'a' => 'Direkt hier auf der Website über den Tickets-sichern-Button oder auf Snapticket. Plätze sind begrenzt – frühzeitig buchen lohnt sich.',
    ],
    [
        'q' => 'Was kosten die Tickets?',
        'a' => $ticketAudienceText,
    ],
    [
        'q' => 'Gibt es Tickets an der Abendkasse?',
        'a' => 'Wenn nicht ausverkauft, ja. Wir empfehlen aber den Vorverkauf, da Shows regelmäßig ausverkauft sind.',
    ],
    [
        'q' => 'Wie komme ich zum Backstage München?',
        'a' => 'Reitknechtstr. 6, 80639 München. Nächste S-Bahn: Hirschgarten (S3/S4/S6/S8), ca. 5 Min. Fußweg. Parkplätze auf dem Gelände vorhanden.',
    ],
    [
        'q' => 'Was ist eine Mixed Comedy Show?',
        'a' => 'Mehrere Comedians treten in einer Nacht auf – jeder mit eigenem Stil und Material. Jede Show ist einzigartig.',
    ],
    [
        'q' => 'Wie oft findet die Backstage Comedy Night statt?',
        'a' => 'Einmal im Monat im Backstage München. Folge uns auf Instagram @backstage.comedy.night oder schau hier vorbei, um keine Termine zu verpassen.',
    ],
    [
        'q' => 'Sind die Tickets digital?',
        'a' => 'Ja. Nach dem Kauf erhältst du dein Ticket per E-Mail und zeigst es am Einlass auf dem Handy vor.',
    ],
];

$firstSlug = $next ? $next['slug'] : '';
$firstEnd = $next ? $next['end'] : '';

$page = [
    'title' => 'Comedy München | Stand-up Comedy Show im Backstage',
    'description' => 'Live-Stand-up in München: mehrere Comedians, wechselndes Line-up und einmal im Monat Comedy im Backstage. Alle Termine, Line-ups und Tickets.',
    'canonical' => bcn_url('/'),
    'isHome' => true,
    'preloadHero' => true,
    'googleVerification' => 'Fw_HdwenSF8C8XDW8YuGiYyNk21V403zkQA6jgo-6es',
    'facebookVerification' => 'yy9ftv9f9qhc87eh6h01xbrfxeeemi',
    'ogDescription' => 'Live-Stand-up im Backstage München: mehrere Comedians, wechselndes Line-up und monatliche Termine.',
    'twitterDescription' => 'Live-Stand-up im Backstage München: mehrere Comedians, wechselndes Line-up und monatliche Termine.',
    'jsonLd' => [
        bcn_schema_organization(),
        bcn_schema_website(),
        bcn_schema_event_series(),
        bcn_schema_faq($homeFaqs),
    ],
];

require __DIR__ . '/includes/head.php';
?>

  <div id="preloader" aria-hidden="true">
    <div class="preloader-logo">
      <img src="/assets/logo.png" alt="" width="160" height="43" />
    </div>
  </div>

  <header class="hero" role="banner">
    <div class="hero-bg" aria-hidden="true"></div>
    <div class="hero-spotlight" aria-hidden="true"></div>
    <div class="hero-content container">
      <span class="hero-eyebrow">München · Backstage · Monatlich</span>
      <h1 class="hero-title">
        <span class="hero-line line-1">Stand-up Comedy in München</span>
        <span class="hero-line line-2">live im Backstage</span>
      </h1>
      <p class="hero-sub">Mehrere Comedians, ein Abend, monatlich live im Backstage München. Mixed Show mit wechselndem Line-up – komplett auf Deutsch.</p>

      <a href="#shows" class="hero-countdown" id="heroCountdown" hidden>
        <span class="countdown-label" id="countdownLabel">Nächste Show · Countdown läuft</span>
        <div class="countdown-timer" id="countdownTimer">
          <div class="countdown-unit">
            <span class="countdown-value" id="cdDays">0</span>
            <span class="countdown-name">Tage</span>
          </div>
          <span class="countdown-sep" aria-hidden="true">:</span>
          <div class="countdown-unit">
            <span class="countdown-value" id="cdHours">00</span>
            <span class="countdown-name">Std</span>
          </div>
          <span class="countdown-sep" aria-hidden="true">:</span>
          <div class="countdown-unit">
            <span class="countdown-value" id="cdMins">00</span>
            <span class="countdown-name">Min</span>
          </div>
          <span class="countdown-sep" aria-hidden="true">:</span>
          <div class="countdown-unit">
            <span class="countdown-value" id="cdSecs">00</span>
            <span class="countdown-name">Sek</span>
          </div>
        </div>
        <span class="countdown-cta" id="countdownCta">Tickets sichern →</span>
      </a>

      <div class="hero-actions">
        <a href="#shows" class="btn btn-primary pulse">Termine ansehen</a>
        <?= bcn_next_ticket_cta($next) ?>
      </div>
    </div>
    <div class="scroll-indicator" aria-hidden="true">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
      Scroll
    </div>
  </header>

  <div class="stats-bar" aria-label="Kennzahlen der Show">
    <div class="stats-inner">
      <div class="stat-item reveal">
        <span class="stat-number" data-counter="5" data-suffix="+">5+</span>
        <span class="stat-label">Comedians pro Show</span>
      </div>
      <div class="stat-divider" aria-hidden="true"></div>
      <div class="stat-item reveal reveal-delay-1">
        <span class="stat-number">1×</span>
        <span class="stat-label">Monatlich in München</span>
      </div>
      <div class="stat-divider" aria-hidden="true"></div>
      <div class="stat-item reveal reveal-delay-2">
        <span class="stat-number">18+</span>
        <span class="stat-label">Show auf Deutsch</span>
      </div>
    </div>
  </div>

  <main>

    <section class="shows-section" id="shows" aria-labelledby="shows-heading">
      <div class="container">
        <div class="shows-header reveal">
          <div>
            <span class="section-label">Nächste Termine</span>
            <h2 id="shows-heading">Comedy Shows in München – Nächste Termine</h2>
            <p style="color:var(--text-secondary);margin-top:12px;">Sichere dir jetzt dein Ticket für die nächste Backstage Comedy Night. Plätze sind begrenzt.</p>
          </div>
          <a href="/termine/" class="btn btn-secondary">Alle Termine</a>
        </div>
        <div
          class="shows-grid"
          id="showsGrid"
          data-ssr="1"
          data-first-slug="<?= bcn_esc($firstSlug) ?>"
          data-first-end="<?= bcn_esc($firstEnd) ?>"
          aria-busy="false"
        >
          <?= bcn_render_show_grid($upcoming, $now) ?>
        </div>
      </div>
    </section>

    <section class="about-section" id="about" aria-labelledby="about-heading">
      <div class="container">
        <div class="about-grid">
          <div class="about-quote-wrap reveal" aria-hidden="true">
            <span class="about-quote-mark">„</span>
          </div>
          <div class="about-content reveal reveal-delay-1">
            <span class="section-label">Die Show</span>
            <h2 id="about-heading">Was ist die Backstage Comedy Night?</h2>
            <p>Bereit für einen Abend voller Lachen? Die <strong>Backstage Comedy Night</strong> ist die monatliche Stand-up-Comedy-Show im Backstage München – mit erfahrenen Comedians, wechselndem Line-up und einer Atmosphäre, die du so nur im Backstage findest.</p>
            <p>Als <strong>Mixed Comedy Show</strong> bringen wir verschiedene Acts der Münchner Szene auf eine Bühne. Jeder Comedian hat seinen eigenen Stil, sein eigenes Material – zusammen ergeben sie einen Abend mit persönlichen Stories, spontanen Momenten und Comedy, die dich abholt.</p>
            <p>Gegründet von <a href="/comedians/yahya-pervaiz/">Yahya Pervaiz</a> (Steh auf Comedy Freising) und <a href="/comedians/bilal-mohammed/">Bilal Mohammed</a> (Geistesblitz Comedy), vereint die Backstage Comedy Night erfahrene Acts aus der Münchner Stand-up-Szene unter einem Dach.</p>
            <div class="about-features">
              <div class="feature-item">
                <span class="feature-icon" aria-hidden="true">✓</span>
                Stand-up Comedy auf Deutsch – authentisch und direkt
              </div>
              <div class="feature-item">
                <span class="feature-icon" aria-hidden="true">✓</span>
                Neue Acts und frisches Material jeden Monat
              </div>
              <div class="feature-item">
                <span class="feature-icon" aria-hidden="true">✓</span>
                Einzigartige Atmosphäre im Backstage München
              </div>
              <div class="feature-item">
                <span class="feature-icon" aria-hidden="true">✓</span>
                Mehrere Comedians pro Show – Mixed Format
              </div>
            </div>
            <a href="/termine/" class="btn btn-primary" style="margin-top:2rem;">Alle Termine ansehen</a>
          </div>
        </div>
      </div>
    </section>

    <section class="team-section" id="team" aria-labelledby="team-heading">
      <div class="container">
        <div class="reveal" style="text-align:center;max-width:720px;margin:0 auto;">
          <span class="section-label">Die Macher</span>
          <h2 id="team-heading">Die Köpfe hinter der Backstage Comedy Night</h2>
          <p style="color:var(--text-secondary);margin-top:12px;">Zwei erfahrene Comedians und Veranstalter aus der Münchner Stand-up-Szene.</p>
        </div>
        <div class="team-grid">
          <article class="team-card reveal">
            <div class="team-photo-wrap">
              <img src="/assets/yahya.JPG" alt="Yahya Pervaiz – Comedian und Co-Founder der Backstage Comedy Night München" width="600" height="800" loading="lazy" />
              <div class="team-photo-overlay" aria-hidden="true"></div>
            </div>
            <div class="team-role">Co-Founder · Steh auf Comedy Freising</div>
            <h3 class="team-name">Yahya Pervaiz</h3>
            <p class="team-bio">Yahya bringt frischen Wind aus Freising nach München. Mit Steh auf Comedy hat er eine der aufstrebenden Comedy-Reihen der Region aufgebaut – jetzt bringt er dasselbe Feuer ins Backstage.</p>
            <div class="team-social">
              <a href="https://www.instagram.com/yahya.pervaiz/" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Yahya Pervaiz auf Instagram">
                @yahya.pervaiz
              </a>
            </div>
          </article>
          <article class="team-card reveal reveal-delay-1">
            <div class="team-photo-wrap">
              <img src="/assets/bilal.jpeg" alt="Bilal Mohammed – Comedian, Moderator und Co-Founder der Backstage Comedy Night München" width="600" height="800" loading="lazy" />
              <div class="team-photo-overlay" aria-hidden="true"></div>
            </div>
            <div class="team-role">Co-Founder · Geistesblitz Comedy</div>
            <h3 class="team-name">Bilal Mohammed</h3>
            <p class="team-bio">Bilal ist ein erfahrener Comedian und Moderator der Münchner Szene. Als Gründer von Geistesblitz Comedy und langjähriger Host weiß er, wie man einen Raum zum Lachen bringt.</p>
            <div class="team-social">
              <a href="https://www.instagram.com/bilal.comedy/" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Bilal Mohammed auf Instagram">
                @bilal.comedy
              </a>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="gallery-section" id="gallery" aria-labelledby="gallery-heading">
      <div class="container">
        <div class="gallery-header reveal">
          <span class="section-label">Impressionen</span>
          <h2 id="gallery-heading">Atmosphäre der Backstage Comedy Night München</h2>
          <p class="gallery-sub">Eindrücke aus unseren Shows – so sieht ein Comedy-Abend im Backstage aus.</p>
        </div>
        <div class="gallery-masonry" id="galleryPreview">
          <?= bcn_render_gallery_grid(9) ?>
        </div>
        <div class="gallery-cta reveal">
          <a href="/galerie.html" class="btn btn-secondary">Alle Fotos ansehen</a>
        </div>
      </div>
    </section>

    <section class="about-section" id="tickets" aria-labelledby="tickets-heading">
      <div class="container" style="max-width:860px;">
        <div class="reveal">
          <span class="section-label">Tickets</span>
          <h2 id="tickets-heading">Für wen ist die Backstage Comedy Night?</h2>
          <p style="color:var(--text-secondary);margin-bottom:16px;">Ob mit Freunden, als Date-Night oder mit Kolleg:innen nach der Arbeit – die Mixed Show passt für alle, die Live-Comedy auf Deutsch mögen. Ab 18 Jahren, Ausweis mitbringen.</p>
          <p style="color:var(--text-secondary);margin-bottom:24px;"><?= bcn_esc($ticketAudienceText) ?> Wähle deinen Termin in der Übersicht, buche über Snapticket und zeig dein Ticket am Einlass auf dem Handy.</p>
          <div class="hero-actions" style="justify-content:flex-start;">
            <?= bcn_next_ticket_cta($next) ?>
            <a href="/tickets/" class="btn btn-secondary">Mehr zu Tickets</a>
          </div>
        </div>
      </div>
    </section>

    <section class="location-section" id="location" aria-labelledby="location-heading">
      <div class="container">
        <div class="reveal" style="margin-bottom:48px;">
          <span class="section-label">Anfahrt</span>
          <h2 id="location-heading">Location: Backstage München – Reitknechtstr. 6</h2>
          <p style="color:var(--text-secondary);margin-top:12px;max-width:640px;">Die Backstage Comedy Night findet im Backstage München statt – einem der bekanntesten Veranstaltungsorte der Stadt.</p>
        </div>
        <div class="location-grid">
          <div class="location-info reveal">
            <div class="location-items">
              <div class="location-item">
                <span class="location-icon" aria-hidden="true">📍</span>
                <div class="location-text">
                  <strong>Adresse</strong>
                  <span><?= bcn_esc(BCN_LOCATION['street']) ?>, <?= bcn_esc(BCN_LOCATION['postal']) ?> <?= bcn_esc(BCN_LOCATION['city']) ?></span>
                </div>
              </div>
              <div class="location-item">
                <span class="location-icon" aria-hidden="true">🚇</span>
                <div class="location-text">
                  <strong>Anreise mit ÖPNV</strong>
                  <span>S-Bahn Hirschgarten (S3/S4/S6/S8) – ca. 5 Min. Fußweg</span>
                </div>
              </div>
              <div class="location-item">
                <span class="location-icon" aria-hidden="true">🚗</span>
                <div class="location-text">
                  <strong>Parken</strong>
                  <span>Parkplätze auf dem Backstage-Gelände vorhanden</span>
                </div>
              </div>
              <div class="location-item">
                <span class="location-icon" aria-hidden="true">🕗</span>
                <div class="location-text">
                  <strong>Zeiten</strong>
                  <span>Einlass: eine Stunde vor Showbeginn · Show ca. 2 Stunden inkl. Pause</span>
                </div>
              </div>
              <div class="location-item">
                <span class="location-icon" aria-hidden="true">♿</span>
                <div class="location-text">
                  <strong>Barrierefreiheit</strong>
                  <span>Das Backstage München ist barrierefrei zugänglich</span>
                </div>
              </div>
            </div>
            <a href="/backstage-muenchen-comedy/" class="btn btn-secondary">Mehr zur Location</a>
          </div>
          <div class="reveal reveal-delay-1">
            <div class="location-map-wrap" id="mapWrap">
              <button type="button" class="btn btn-secondary" id="loadMapBtn">Karte laden</button>
              <template id="mapTemplate">
                <iframe
                  src="<?= bcn_esc($mapEmbed) ?>"
                  width="100%"
                  height="420"
                  loading="lazy"
                  title="Backstage München auf Google Maps"
                  referrerpolicy="no-referrer-when-downgrade"
                  style="border:0;"
                  allowfullscreen
                ></iframe>
              </template>
            </div>
            <p class="map-privacy">Beim Laden der Karte wird eine Verbindung zu Google hergestellt. Mehr dazu in der <a href="/datenschutz.html">Datenschutzerklärung</a>.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="faq-section" id="faq" aria-labelledby="faq-heading">
      <div class="container">
        <div class="faq-header reveal">
          <span class="section-label">FAQ</span>
          <h2 id="faq-heading">Häufige Fragen zur Backstage Comedy Night München</h2>
          <p style="color:var(--text-secondary);margin-top:12px;">Alles, was du vor deinem Comedy-Abend wissen musst.</p>
        </div>
        <div class="faq-list reveal" role="list">
<?php foreach ($homeFaqs as $faq): ?>
          <div class="faq-item" role="listitem">
            <button class="faq-question" type="button" aria-expanded="false">
              <?= bcn_esc($faq['q']) ?>
              <svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            </button>
            <div class="faq-answer" role="region">
              <p><?= bcn_esc($faq['a']) ?></p>
            </div>
          </div>
<?php endforeach; ?>
        </div>
      </div>
    </section>

    <section class="contact-section" id="contact" aria-labelledby="contact-heading">
      <div class="container">
        <span class="section-label reveal">Kontakt</span>
        <h2 id="contact-heading" class="reveal">Fragen, Kooperationen oder Presseanfragen?</h2>
        <p class="reveal">Meld dich einfach – wir freuen uns über jede Nachricht.</p>
        <a href="mailto:<?= bcn_esc(BCN_EMAIL) ?>" class="contact-email reveal"><?= bcn_esc(BCN_EMAIL) ?></a>
        <div class="contact-socials reveal">
          <a href="<?= bcn_esc(BCN_INSTAGRAM) ?>" target="_blank" rel="noopener noreferrer" class="contact-social-link" aria-label="Backstage Comedy Night auf Instagram">
            @backstage.comedy.night
          </a>
        </div>
      </div>
    </section>

  </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
