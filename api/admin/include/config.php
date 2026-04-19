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

if (!$con || mysqli_connect_errno()) {
    $errorMsg = mysqli_connect_error() ?: "Could not connect to database server.";
    error_log("Admin DB Connection Error: " . $errorMsg);
    
    // Provide a helpful message for local development
    if (DB_SERVER === 'localhost' || DB_SERVER === '127.0.0.1') {
        $_SESSION['errmsg'] = "Database Connection Failed: Please ensure MySQL is running in XAMPP and the 'shopping' database is imported.";
    } else {
        $_SESSION['errmsg'] = "Database is currently unavailable. Please contact the administrator.";
    }
}

// Global debug settings
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

/**
 * Check if database is ready
 */
function db_ready() {
    global $con;
    return $con && !mysqli_connect_errno();
}
?>