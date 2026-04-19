<?php
/**
 * Nexus Elite Admin Configuration
 * Environment-aware connection for XAMPP and Production
 */

// Database credentials
define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Disable mysqli exceptions for manual handling
mysqli_report(MYSQLI_REPORT_OFF);

// Attempt connection
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Error logging and session handling
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$GLOBALS['DEMO_MODE'] = false;

if (!$con || mysqli_connect_errno()) {
    $errorMsg = mysqli_connect_error() ?: "Could not connect to database server.";
    error_log("Admin DB Connection Error: " . $errorMsg);
    
    // Enable Demo Mode if connection fails
    $GLOBALS['DEMO_MODE'] = true;
    
    // Provide a helpful message for local development
    if (DB_SERVER === 'localhost' || DB_SERVER === '127.0.0.1') {
        $_SESSION['errmsg'] = "Database Offline: Running in DEMO MODE. Use 'admin' / 'admin' to explore.";
    } else {
        $_SESSION['errmsg'] = "Database is currently unavailable. Running in DEMO MODE.";
    }
}

// Global debug settings
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

/**
 * Check if database is ready or if we are in demo mode
 */
function db_ready() {
    global $con;
    return ($con && !mysqli_connect_errno()) || ($GLOBALS['DEMO_MODE'] ?? false);
}
?>
