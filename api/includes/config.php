<?php
/**
 * Nexus Elite Global Configuration
 * Optimized for local XAMPP and Cloud Deployment
 */

// Security Headers
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
// Relaxed CSP for local development and Google integration
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://accounts.google.com https://apis.google.com https://cdn.jsdelivr.net https://code.jquery.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https://*.googleusercontent.com; frame-src 'self' https://accounts.google.com https://www.google.com;");

// Environment Detection (Local vs Cloud)
$is_cloud = (isset($_SERVER['VERCEL']) || (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !== 'localhost'));

if ($is_cloud) {
    // Production (Cloud) - Prioritize Vercel Variables with hardcoded fallbacks
    $db_host = getenv('DB_SERVER') ?: 'mysql-8d474cb-gounderdivakaran-0f47.g.aivencloud.com';
    $db_user = getenv('DB_USER')   ?: 'avnadmin';
    $db_pass = getenv('DB_PASS')   ?: 'AVNS_S7QTFAZrai9x7WfPn4F';
    $db_name = getenv('DB_NAME')   ?: 'defaultdb';
    $db_port = getenv('DB_PORT')   ?: '12863';
    
    define('DB_SERVER', $db_host);
    define('DB_USER',   $db_user);
    define('DB_PASS',   $db_pass);
    define('DB_NAME',   $db_name);
    define('DB_PORT',   (int)$db_port);
} else {
    // Local (XAMPP)
    define('DB_SERVER', 'localhost');
    define('DB_USER',   'root');
    define('DB_PASS',   '');
    define('DB_NAME',   'shopping');
    define('DB_PORT',   3306);
}

// Establish Connection
$con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, DB_PORT);

if (!$con) {
    $db_error = mysqli_connect_error();
}

// Environment-aware error reporting
if (isset($_SERVER['VERCEL']) || (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] !== 'localhost')) {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', 1);
} else {
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
}

$GLOBALS['DEMO_MODE'] = false;

// Auto-enable Demo Mode if on Vercel and no remote DB
if (isset($_SERVER['VERCEL']) && DB_SERVER === 'localhost') {
    $GLOBALS['DEMO_MODE'] = true;
}

// Check connection and fallback to Demo Mode
if (mysqli_connect_errno() || !$con) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $GLOBALS['DEMO_MODE'] = true;
    $_SESSION['db_error'] = mysqli_connect_error();
}

/**
 * Check if database is ready
 */
function db_ready() {
    global $con;
    return $con && !mysqli_connect_errno();
}

/**
 * Safe Query Helper to prevent fatal errors when DB is offline
 */
function safe_query($sql) {
    global $con;
    if (!db_ready()) return false;
    return mysqli_query($con, $sql);
}

/**
 * Safe Prepared Statement Helper
 */
function safe_query_prepare($sql) {
    global $con;
    if (!db_ready()) return false;
    return mysqli_prepare($con, $sql);
}
?>


