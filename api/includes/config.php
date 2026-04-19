<?php
/**
 * Nexus Elite Global Configuration
 * Optimized for local XAMPP and Cloud Deployment
 */

define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
define('DB_USER',   getenv('DB_USER')   ?: 'root');
define('DB_PASS',   getenv('DB_PASS')   ?: '');
define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');

// Disable mysqli exceptions
mysqli_report(MYSQLI_REPORT_OFF);

// Attempt connection (suppress warnings with @)
try {
    if (substr(DB_SERVER, 0, 10) === '/cloudsql/') {
        $con = @mysqli_connect(null, DB_USER, DB_PASS, DB_NAME, null, DB_SERVER);
    } else {
        $con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    }
} catch (Exception $e) {
    $con = false;
}

// Error logging optimized for environment
if (isset($_SERVER['VERCEL'])) {
    ini_set('display_errors', 0);
    error_reporting(E_ERROR | E_PARSE);
} else {
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);
}

$GLOBALS['DEMO_MODE'] = false;

// Auto-enable Demo Mode if on Vercel and no remote DB
if (isset($_SERVER['VERCEL']) && DB_SERVER === 'localhost') {
    $GLOBALS['DEMO_MODE'] = true;
}

// Check connection
if (!$con || mysqli_connect_errno()) {
    $errorMsg = mysqli_connect_error() ?: "Could not connect to database server.";
    error_log("Failed to connect to MySQL: " . $errorMsg);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $GLOBALS['DEMO_MODE'] = true;
}

/**
 * Check if database is ready or if we are in demo mode
 */
function db_ready() {
    global $con;
    return ($con && !mysqli_connect_errno()) || ($GLOBALS['DEMO_MODE'] ?? false);
}
?>

