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

try {
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
} catch (Exception $e) {
    $con = false;
    error_log("Admin Connection Exception: " . $e->getMessage());
}

// Error logging
ini_set('display_errors', 1);
ini_set('log_errors', 1);
error_reporting(E_ALL);

if (!$con || mysqli_connect_errno()) {
    $errorMsg = $con ? mysqli_connect_error() : "Could not connect to database server.";
    error_log("Failed to connect to MySQL: " . $errorMsg);
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (DB_SERVER === 'localhost') {
        $_SESSION['errmsg'] = "Database unavailable on live site. Please configure environment variables.";
    } else {
        $_SESSION['errmsg'] = "Database connection failed: " . $errorMsg;
    }
}
?>