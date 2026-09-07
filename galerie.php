<?php
declare(strict_types=1);

require_once __DIR__ . '/lib/render.php';

$page = [
    'title' => 'Galerie – Stand-up Comedy Fotos aus München | Backstage Comedy Night',
    'description' => 'Fotos und Impressionen von der Backstage Comedy Night im Backstage München – Live-Momente von der Bühne und aus dem Publikum.',
    'canonical' => bcn_url('/galerie.php'),
    'activeNav' => 'galerie',
    'bodyClass' => 'subpage',
    'jsonLd' => [
        bcn_schema_breadcrumb([
            ['name' => 'Startseite', 'url' => bcn_url('/')],
            ['name' => 'Galerie'],
        ]),
        [
            '@context' => 'https://schema.org',
            '@type' => 'ImageGallery',
            'name' => 'Backstage Comedy Night München – Galerie',
            'description' => 'Fotos und Impressionen von der Backstage Comedy Night – Stand-up Comedy Show in München',
            'url' => bcn_url('/galerie.php'),
            'author' => [
                '@type' => 'Organization',
                'name' => BCN_SITE_NAME,
                'url' => bcn_url('/'),
            ],
        ],
    ],
];

require __DIR__ . '/includes/head.php';
?>
<main>
  <div class="inner-hero">
    <div class="container">
      <span class="section-label">Impressionen</span>
      <h1>Galerie – Stand-up Comedy in München</h1>
      <p>Fotos und Impressionen von der Backstage Comedy Night im Backstage München.</p>
    </div>
  </div>

  <div class="container">
    <div class="gallery-page-grid" aria-label="Galerie aller Show-Fotos">
      <?= bcn_render_gallery_grid(12, true) ?>
    </div>
  </div>

  <section class="section" style="padding-top:60px;">
    <div class="container" style="max-width:760px;">
      <h2 style="font-size:clamp(1.35rem,3vw,1.8rem);margin-bottom:1rem;">So sieht ein Abend bei der Backstage Comedy Night aus</h2>
      <p style="color:var(--text-secondary);margin-bottom:1rem;">Die Fotos entstehen live bei unseren Shows im Backstage München: Comedians auf der Bühne, Publikum nah dran, Club-Atmosphäre.</p>
      <p style="color:var(--text-secondary);margin-bottom:1.5rem;">Lust, beim nächsten Mal selbst dabei zu sein? Termine in der <a href="/termine/" style="color:var(--accent);">Terminübersicht</a>, Tickets auf der <a href="/tickets/" style="color:var(--accent);">Ticket-Seite</a>.</p>
      <a href="/tickets/" class="btn btn-primary">Tickets sichern</a>
    </div>
  </section>
</main>

<div id="lightbox" class="lightbox" role="dialog" aria-modal="true" aria-label="Foto-Lightbox" hidden>
  <button type="button" class="lightbox-close" aria-label="Lightbox schließen">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </button>
  <button type="button" class="lightbox-prev" aria-label="Vorheriges Foto">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
  </button>
  <div class="lightbox-img-wrap">
    <img id="lightboxImg" src="" alt="" />
  </div>
  <button type="button" class="lightbox-next" aria-label="Nächstes Foto">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
  </button>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
