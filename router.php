<?php
declare(strict_types=1);

/**
 * Router for PHP built-in server: php -S localhost:8080 router.php
 * Mirrors key Apache rewrite rules from .htaccess.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/');

// Block internals
if (preg_match('#^/(lib|cache|cron|includes)(/|$)#', $uri)) {
    http_response_code(403);
    echo 'Forbidden';
    return true;
}

$map = [
    '/' => '/index.php',
    '/galerie.html' => '/galerie.php',
    '/impressum.html' => '/impressum.php',
    '/datenschutz.html' => '/datenschutz.php',
];

if (isset($map[$uri])) {
    require __DIR__ . $map[$uri];
    return true;
}

if (preg_match('#^/termine/([a-z0-9\-]+)/?$#', $uri, $m)) {
    $_GET['slug'] = $m[1];
    require __DIR__ . '/termine/event.php';
    return true;
}

// Directory indexes
if (str_ends_with($uri, '/')) {
    $dirIndex = __DIR__ . rtrim($uri, '/') . '/index.php';
    if (is_file($dirIndex)) {
        require $dirIndex;
        return true;
    }
}

$file = __DIR__ . $uri;
if ($uri !== '/' && is_file($file)) {
    return false; // serve static
}

http_response_code(404);
if (is_file(__DIR__ . '/404.html')) {
    readfile(__DIR__ . '/404.html');
} else {
    echo '404';
}
return true;
