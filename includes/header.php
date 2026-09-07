<?php
declare(strict_types=1);

$activeNav = $page['activeNav'] ?? '';
$isHome = ($page['isHome'] ?? false) === true;
$navPrefix = $isHome ? '' : '/';

function bcn_nav_current(string $key, string $activeNav): string
{
    return $key === $activeNav ? ' aria-current="page"' : '';
}
?>
  <nav class="nav<?= $isHome ? '' : ' scrolled' ?>" role="navigation" aria-label="Hauptnavigation">
    <div class="nav-inner">
      <a href="<?= $isHome ? '#' : '/' ?>" class="nav-logo" aria-label="Backstage Comedy Night – Startseite">
        <img src="/assets/logo.png" alt="Backstage Comedy Night Logo" width="140" height="36" />
      </a>
      <ul class="nav-links" role="list">
<?php if ($isHome): ?>
        <li><a href="#shows">Shows</a></li>
<?php endif; ?>
        <li><a href="/termine/"<?= bcn_nav_current('termine', $activeNav) ?>>Termine</a></li>
        <li><a href="/tickets/"<?= bcn_nav_current('tickets', $activeNav) ?>>Tickets</a></li>
        <li><a href="/stand-up-comedy-muenchen/"<?= bcn_nav_current('standup', $activeNav) ?>>Stand-up</a></li>
        <li><a href="/backstage-muenchen-comedy/"<?= bcn_nav_current('location', $activeNav) ?>>Location</a></li>
        <li><a href="/gruppen-firmenevents/"<?= bcn_nav_current('gruppen', $activeNav) ?>>Gruppen</a></li>
<?php if ($isHome): ?>
        <li><a href="#faq">FAQ</a></li>
<?php else: ?>
        <li><a href="/galerie.html"<?= bcn_nav_current('galerie', $activeNav) ?>>Galerie</a></li>
<?php endif; ?>
      </ul>
      <a href="<?= $isHome ? '#shows' : '/tickets/' ?>" class="nav-cta" aria-label="Tickets sichern">Tickets sichern</a>
      <button class="nav-hamburger" aria-label="Menü öffnen" aria-expanded="false" type="button">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>
  <div class="nav-overlay" aria-hidden="true">
<?php if ($isHome): ?>
    <a href="#shows">Shows</a>
<?php endif; ?>
    <a href="/termine/">Termine</a>
    <a href="/tickets/">Tickets</a>
    <a href="/stand-up-comedy-muenchen/">Stand-up</a>
    <a href="/backstage-muenchen-comedy/">Location</a>
    <a href="/gruppen-firmenevents/">Gruppen</a>
    <a href="/galerie.html">Galerie</a>
    <a href="<?= $isHome ? '#shows' : '/tickets/' ?>" class="nav-cta-overlay">Tickets sichern</a>
  </div>
