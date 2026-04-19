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
if (str_starts_with(DB_SERVER, '/cloudsql/')) {
    // Connect via Unix Socket (Cloud Run / Cloud SQL)
    $con = mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
} else {
    // Standard TCP connection (Local XAMPP)
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
}

// Performance & Error Handling
ini_set('display_errors', getenv('APP_DEBUG') ? 1 : 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Check connection
if (mysqli_connect_errno()) {
    error_log("Failed to connect to MySQL: " . mysqli_connect_error());
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['errmsg'] = "Database connection failed. Please ensure MySQL is started in XAMPP.";
}
?>
