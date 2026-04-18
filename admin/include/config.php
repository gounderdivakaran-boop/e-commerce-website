<?php
define('DB_SERVER', getenv('DB_SERVER') ?: '127.0.0.1');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Create connection
if (getenv('DB_SERVER') && str_starts_with(getenv('DB_SERVER'), '/cloudsql/')) {
    $con = mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
} else {
    $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
}

// Error logging
ini_set('display_errors', getenv('APP_DEBUG') ? 1 : 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

if (mysqli_connect_errno()) {
    error_log("Connection error: " . mysqli_connect_error());
}
?>