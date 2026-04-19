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

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Error logging
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

$GLOBALS['DEMO_MODE'] = false;

if (mysqli_connect_errno()) {
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