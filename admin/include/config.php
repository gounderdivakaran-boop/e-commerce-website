<?php
/**
 * Nexus Elite Admin Configuration
 * Environment-aware connection
 */

define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Disable mysqli exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Disable mysqli exceptions
mysqli_report(MYSQLI_REPORT_OFF);

$con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Error logging
if (!isset($_SERVER['VERCEL'])) {
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_PARSE);
}

$GLOBALS['DEMO_MODE'] = false;

// Auto-enable Demo Mode if on Vercel and no remote DB configured
if (isset($_SERVER['VERCEL']) && DB_SERVER === 'localhost') {
    $GLOBALS['DEMO_MODE'] = true;
}

if (mysqli_connect_errno() || !$con) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $GLOBALS['DEMO_MODE'] = true;
    $_SESSION['errmsg'] = "Database Offline: Running in DEMO MODE. Use 'admin' / 'admin' to explore.";
}

/**
 * Check if database is ready or if we are in demo mode
 */
function db_ready() {
    global $con;
    return ($con && !mysqli_connect_errno()) || ($GLOBALS['DEMO_MODE'] ?? false);
}
?>
