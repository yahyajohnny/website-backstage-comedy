<?php
declare(strict_types=1);

/**
 * Site-wide configuration for Backstage Comedy Night.
 */
const BCN_SITE_NAME = 'Backstage Comedy Night';
const BCN_SITE_NAME_FULL = 'Backstage Comedy Night München';
const BCN_BASE_URL = 'https://www.backstage-comedy.de';
const BCN_EMAIL = 'haha@backstage-comedy.de';
const BCN_INSTAGRAM = 'https://www.instagram.com/backstage.comedy.night/';
const BCN_TIMEZONE = 'Europe/Berlin';
const BCN_ASSET_VERSION = '20260907b';

const BCN_LOCATION = [
    'name' => 'Backstage München',
    'street' => 'Reitknechtstr. 6',
    'city' => 'München',
    'postal' => '80639',
    'country' => 'DE',
    'lat' => 48.1444,
    'lng' => 11.5278,
];

const BCN_MATOMO_URL = '//matomo.yahyapervaiz.com/';
const BCN_MATOMO_SITE_ID = '3';

/** Cache TTL for live event refreshes (seconds). */
const BCN_EVENTS_CACHE_TTL = 300;

/** Optional upstream refresh URL (defaults to local cache / optional env). */
const BCN_EVENTS_UPSTREAM_ENV = 'BCN_EVENTS_UPSTREAM';

/**
 * Absolute filesystem root of the public site.
 */
function bcn_root(): string
{
    return dirname(__DIR__);
}

function bcn_cache_path(string $file): string
{
    return bcn_root() . '/cache/' . ltrim($file, '/');
}

function bcn_now(): DateTimeImmutable
{
    return new DateTimeImmutable('now', new DateTimeZone(BCN_TIMEZONE));
}

function bcn_esc(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function bcn_asset(string $path): string
{
    $path = '/' . ltrim($path, '/');
    return $path . (str_contains($path, '?') ? '&' : '?') . 'v=' . BCN_ASSET_VERSION;
}

function bcn_url(string $path = '/'): string
{
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }
    return rtrim(BCN_BASE_URL, '/') . '/' . ltrim($path, '/');
}
