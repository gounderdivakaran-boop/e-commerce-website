<?php
/**
 * Single-entry-point router for Vercel.
 * Routes all requests to the correct PHP file using ONE Lambda.
 */

// Enable error reporting for debugging the white screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = ltrim($uri, '/');

// Absolute path to the project root
$rootDir = dirname(__DIR__);

// Determine route target
if (strpos($uri, 'admin/') === 0 || $uri === 'admin') {
    // Admin route
    $page = (strlen($uri) > 6) ? substr($uri, 6) : 'index';
    if (empty($page)) $page = 'index';
    
    // Remote .php if present for normalization, then re-add it
    $page = preg_replace('/\.php$/', '', $page) . '.php';
    
    $targetDir = $rootDir . '/admin';
    $file      = $targetDir . '/' . $page;
} else {
    // Front-end route
    if (empty($uri)) {
        $page = 'index.php';
    } else {
        $page = preg_replace('/\.php$/', '', $uri) . '.php';
    }
    $targetDir = $rootDir;
    $file      = $targetDir . '/' . $page;
}

// Serve the file if it exists, else 404
if (file_exists($file)) {
    chdir($targetDir); // Fix relative includes
    include $file;
} else {
    http_response_code(404);
    echo '<h1>404 - Page Not Found</h1>';
    echo '<p>Seeking file: ' . htmlspecialchars($file) . '</p>';
    echo '<p>From URI: ' . htmlspecialchars($uri) . '</p>';
}
