<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
/**
 * Router script for Railway / PHP Built-in Web Server.
 * Allows running `php -S 0.0.0.0:$PORT router.php` on Railway cleanly without mod_rewrite.
 */

$rawUri = $_SERVER['REQUEST_URI'] ?? '/';
$rawUri = '/' . ltrim($rawUri, '/');
$uri = urldecode(parse_url($rawUri, PHP_URL_PATH));
$uri = preg_replace('#/+#', '/', $uri);

if (!empty($_SERVER['HTTP_HOST']) && str_starts_with($uri, '/' . $_SERVER['HTTP_HOST'])) {
    $uri = substr($uri, strlen('/' . $_SERVER['HTTP_HOST']));
    if ($uri === '' || $uri === false) {
        $uri = '/';
    }
}

$path = __DIR__ . $uri;

// Serve static files directly if they exist in the root or public folders
if ($uri !== '/' && is_file($path)) {
    return false;
}

if (str_starts_with($uri, '/public/') && is_file(__DIR__ . $uri)) {
    return false;
}

if ($uri !== '/' && is_file(__DIR__ . '/public' . $uri)) {
    $mime = match (strtolower(pathinfo($uri, PATHINFO_EXTENSION))) {
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg', 'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff', 'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'json' => 'application/json',
        default => 'application/octet-stream',
    };
    header('Content-Type: ' . $mime);
    readfile(__DIR__ . '/public' . $uri);
    return true;
}

// Route dynamic requests to public/index.php
$_GET['page'] = ltrim($uri, '/');
if (str_starts_with($_GET['page'], 'public/index.php?page=')) {
    $_GET['page'] = substr($_GET['page'], strlen('public/index.php?page='));
} elseif (str_starts_with($_GET['page'], 'index.php?page=')) {
    $_GET['page'] = substr($_GET['page'], strlen('index.php?page='));
} elseif (str_starts_with($_GET['page'], 'public/')) {
    $_GET['page'] = substr($_GET['page'], strlen('public/'));
}

if ($_GET['page'] === '' || $_GET['page'] === 'index.php' || $_GET['page'] === 'public/index.php') {
    $_GET['page'] = 'home';
}

require_once __DIR__ . '/public/index.php';
