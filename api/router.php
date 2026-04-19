<?php
/**
 * Single-entry-point router for Vercel.
 * All requests go through this file, which resolves
 * the correct PHP page from the api/ directory.
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

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
    if (!str_ends_with($page, '.php')) $page .= '.php';
    $targetDir = $apiDir . '/admin';
    $file = $targetDir . '/' . $page;
} else {
    $page = $uri;
    if (!str_ends_with($page, '.php') && !str_contains($page, '.')) $page .= '.php';
    $targetDir = $apiDir;
    $file = $targetDir . '/' . $page;
}

if (file_exists($file)) {
    chdir($targetDir);
    include $file;
} else {
    http_response_code(404);
    echo "<!DOCTYPE html><html><head><title>404 - Not Found</title>";
    echo "<style>body{font-family:'Outfit',sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f8fafc;}";
    echo ".box{text-align:center;padding:60px;}.box h1{font-size:80px;color:#6366f1;margin:0;}.box p{color:#64748b;font-size:18px;}</style></head>";
    echo "<body><div class='box'><h1>404</h1><p>The page you're looking for doesn't exist.</p><a href='/' style='color:#6366f1;'>Go Home</a></div></body></html>";
}
