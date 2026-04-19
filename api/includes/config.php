<?php
/**
 * Nexus Elite Global Configuration
 * Optimized for local XAMPP and Cloud Deployment
 */

define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Create connection
// Disable mysqli exceptions (to prevent fatal crashes on PHP 8.1+)
mysqli_report(MYSQLI_REPORT_OFF);

try {
    if (substr(DB_SERVER, 0, 10) === '/cloudsql/') {
        // Connect via Unix Socket (Cloud Run / Cloud SQL)
        $con = mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
    } else {
        // Standard TCP connection (Local XAMPP or Cloud DB)
        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    }
} catch (Exception $e) {
    $con = false;
    error_log("Connection Exception: " . $e->getMessage());
}

// Performance & Error Handling
ini_set('display_errors', 1); // Forced ON for debugging white screen
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Check connection
if (!$con || mysqli_connect_errno()) {
    $errorMsg = $con ? mysqli_connect_error() : "Could not connect to database server.";
    error_log("Failed to connect to MySQL: " . $errorMsg);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Provide a helpful message for deployment
    if (DB_SERVER === 'localhost') {
        $_SESSION['errmsg'] = "Database unavailable. If you are on the live site, please configure your Cloud Database environment variables.";
    } else {
        $_SESSION['errmsg'] = "Database connection error: " . $errorMsg;
    }
}
?>