<?php
declare(strict_types=1);

require_once dirname(__DIR__) . '/lib/render.php';

/**
 * Expected $page keys:
 * title, description, canonical, ogType?, robots?, jsonLd[]?, bodyClass?,
 * preloadHero?, activeNav?
 */
$page = $page ?? [];
$title = $page['title'] ?? BCN_SITE_NAME_FULL;
$description = $page['description'] ?? '';
$canonical = $page['canonical'] ?? bcn_url('/');
$ogType = $page['ogType'] ?? 'website';
$robots = $page['robots'] ?? 'index, follow, max-image-preview:large';
$ogImage = $page['ogImage'] ?? bcn_url('/assets/og-image.jpg');
$ogTitle = $page['ogTitle'] ?? $title;
$ogDescription = $page['ogDescription'] ?? $description;
$twitterTitle = $page['twitterTitle'] ?? $ogTitle;
$twitterDescription = $page['twitterDescription'] ?? $ogDescription;
$bodyClass = $page['bodyClass'] ?? '';
$jsonLd = $page['jsonLd'] ?? [];
$extraHead = $page['extraHead'] ?? '';
?><!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= bcn_esc($title) ?></title>
  <meta name="description" content="<?= bcn_esc($description) ?>" />
  <meta name="robots" content="<?= bcn_esc($robots) ?>" />
  <meta name="theme-color" content="#0a0a0a" />
  <link rel="canonical" href="<?= bcn_esc($canonical) ?>" />
<?php if (!empty($page['googleVerification'])): ?>
  <meta name="google-site-verification" content="<?= bcn_esc($page['googleVerification']) ?>" />
<?php endif; ?>
<?php if (!empty($page['facebookVerification'])): ?>
  <meta name="facebook-domain-verification" content="<?= bcn_esc($page['facebookVerification']) ?>" />
<?php endif; ?>
  <meta property="og:title" content="<?= bcn_esc($ogTitle) ?>" />
  <meta property="og:description" content="<?= bcn_esc($ogDescription) ?>" />
  <meta property="og:url" content="<?= bcn_esc($canonical) ?>" />
  <meta property="og:type" content="<?= bcn_esc($ogType) ?>" />
  <meta property="og:site_name" content="<?= bcn_esc(BCN_SITE_NAME_FULL) ?>" />
  <meta property="og:image" content="<?= bcn_esc($ogImage) ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:locale" content="de_DE" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= bcn_esc($twitterTitle) ?>" />
  <meta name="twitter:description" content="<?= bcn_esc($twitterDescription) ?>" />
  <meta name="twitter:image" content="<?= bcn_esc($ogImage) ?>" />
  <link rel="icon" href="/assets/favicon.ico" sizes="any" />
  <link rel="icon" href="/assets/favicon.svg" type="image/svg+xml" />
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon-32.png" />
  <link rel="apple-touch-icon" href="/assets/apple-touch-icon.png" />
  <link rel="manifest" href="/site.webmanifest" />
  <link rel="preload" href="/assets/fonts/outfit-400-latin.woff2" as="font" type="font/woff2" crossorigin />
  <link rel="preload" href="/assets/fonts/outfit-800-latin.woff2" as="font" type="font/woff2" crossorigin />
  <link rel="stylesheet" href="<?= bcn_esc(bcn_asset('/assets/fonts/outfit.css')) ?>" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="<?= bcn_esc(bcn_asset('/assets/fonts/outfit.css')) ?>" /></noscript>
<?php if (!empty($page['preloadHero'])): ?>
  <link rel="preload" href="/assets/img/hero-1280.webp" as="image" type="image/webp" fetchpriority="high" />
<?php endif; ?>
  <link rel="stylesheet" href="<?= bcn_esc(bcn_asset('/styles.css')) ?>" />
<?php foreach ($jsonLd as $block): ?>
  <?= bcn_json_ld($block) . "\n" ?>
<?php endforeach; ?>
  <?= $extraHead ?>
</head>
<body<?= $bodyClass !== '' ? ' class="' . bcn_esc($bodyClass) . '"' : '' ?>>
<?php require __DIR__ . '/header.php'; ?>
