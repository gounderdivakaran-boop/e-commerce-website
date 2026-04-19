<?php
if (!defined('DB_SERVER')) {
define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');
}

// Error logging
ini_set('display_errors', getenv('APP_DEBUG') ? 1 : 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

// Create connection (non-fatal)
$con = false;
$db_connected = false;

try {
    if (str_starts_with(DB_SERVER, '/cloudsql/')) {
        $con = @mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
    } else {
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