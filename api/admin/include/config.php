<?php
/**
 * Nexus Elite Admin Configuration
 */

include_once(__DIR__ . '/../../includes/config.php');

// If the above include fails for some reason, we fallback to a local copy
if (!function_exists('db_ready')) {
    define('DB_SERVER', getenv('DB_SERVER') ?: 'localhost');
    define('DB_USER',   getenv('DB_USER')   ?: 'root');
    define('DB_PASS',   getenv('DB_PASS')   ?: '');
    define('DB_NAME',   getenv('DB_NAME')   ?: 'shopping');
    
    $con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    $GLOBALS['DEMO_MODE'] = (mysqli_connect_errno() || !$con);
    
    function db_ready() {
        global $con;
        return $con && !mysqli_connect_errno();
    }
}
?>

