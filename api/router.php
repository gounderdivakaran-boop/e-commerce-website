<?php
/**
 * Single-entry-point router for Vercel.
 * All requests go through this file, which resolves
 * the correct PHP page from the api/ directory.
 */

ob_start();

// Error reporting optimized for environment
if (isset($_SERVER['VERCEL'])) {
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_PARSE);
    
    // Security Headers to prevent "Dangerous Site" warnings
    header("X-Frame-Options: SAMEORIGIN");
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("Referrer-Policy: strict-origin-when-cross-origin");
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
    header("Content-Security-Policy: default-src 'self' https: 'unsafe-inline' 'unsafe-eval'; img-src 'self' data: https:; font-src 'self' https: data:;");
} else {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


// Log the request for debugging
error_log("Router handling request: " . $_SERVER['REQUEST_URI']);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = ltrim($uri, '/');

$apiDir = __DIR__;

// Handle empty URI (root index)
if (empty($uri)) {
    $uri = 'index.php';
}

// Determine if it is an admin route
$isAdmin = (strpos($uri, 'admin/') === 0 || $uri === 'admin');

if ($isAdmin) {
    $page = ($uri === 'admin' || $uri === 'admin/') ? 'index.php' : substr($uri, 6);
    if (empty($page) || $page === '/') $page = 'index.php';
    if (substr($page, -4) !== '.php') $page .= '.php';
    $targetDir = $apiDir . '/admin';
    $file = $targetDir . '/' . $page;
} else {
    $page = $uri;
    if (substr($page, -4) !== '.php' && strpos($page, '.') === false) $page .= '.php';
    $targetDir = $apiDir;
    $file = $targetDir . '/' . $page;
}

// Check if the request is for a static file (like an image)
$rootFile = __DIR__ . '/../' . $uri;
if (file_exists($rootFile) && !is_dir($rootFile) && strpos($uri, '.php') === false) {
    $mime = 'application/octet-stream';
    if (strpos($uri, '.png') !== false) $mime = 'image/png';
    if (strpos($uri, '.jpg') !== false || strpos($uri, '.jpeg') !== false) $mime = 'image/jpeg';
    if (strpos($uri, '.gif') !== false) $mime = 'image/gif';
    if (strpos($uri, '.css') !== false) $mime = 'text/css';
    if (strpos($uri, '.js') !== false) $mime = 'application/javascript';
    
    header('Content-Type: ' . $mime);
    readfile($rootFile);
    exit;
}

if (file_exists($file)) {
    chdir($targetDir);
    include $file;
} else {
    http_response_code(404);
    echo "<!DOCTYPE html><html><head><title>404 - Not Found</title>";
    echo "<style>body{font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f8fafc;}";
    echo ".box{text-align:center;padding:60px;}.box h1{font-size:80px;color:#6366f1;margin:0;}.box p{color:#64748b;font-size:18px;}</style></head>";
    echo "<body><div class='box'><h1>404</h1><p>The page you're looking for doesn't exist.</p><a href='/' style='color:#6366f1; text-decoration: none;'>&larr; Go Home</a></div></body></html>";
}
?>
