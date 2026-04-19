<?php
/**
 * Nexus Elite Global Configuration
 * Optimized for local XAMPP and Cloud Deployment
 */

define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Performance & Error Handling
ini_set('display_errors', getenv('APP_DEBUG') ? 1 : 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Create connection (with error suppression to avoid fatal on missing MySQL)
$con = false;
$db_connected = false;

try {
    if (str_starts_with(DB_SERVER, '/cloudsql/')) {
        // Connect via Unix Socket (Cloud Run / Cloud SQL)
        $con = @mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
    } else {
        // Standard TCP connection (Local XAMPP)
        $con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    }
    
    if ($con && !mysqli_connect_errno()) {
        $db_connected = true;
    } else {
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        $con = false;
    }
} catch (Exception $e) {
    error_log("MySQL connection exception: " . $e->getMessage());
    $con = false;
}
?>