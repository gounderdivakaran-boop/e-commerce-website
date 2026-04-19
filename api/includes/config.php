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

// Start output buffering so we can recover from fatal errors
if (!ob_get_level()) {
    ob_start();
}

// Global error handler to prevent white screens from mysqli warnings/errors
set_error_handler(function($severity, $message, $file, $line) {
    // If it's a mysqli-related error and DB isn't connected, suppress it
    if (stripos($message, 'mysqli') !== false && !$GLOBALS['db_connected']) {
        error_log("Suppressed DB error: $message in $file:$line");
        return true; // Suppress the error
    }
    // Let other errors pass through
    return false;
}, E_WARNING | E_NOTICE);

// Shutdown handler: catch fatal errors (TypeError from mysqli on null $con)
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE])) {
        // Check if it's a DB-related fatal error
        if (stripos($error['message'], 'mysqli') !== false || 
            stripos($error['message'], 'null given') !== false ||
            stripos($error['message'], 'bool given') !== false) {
            // Clean any partial output
            while (ob_get_level()) ob_end_clean();
            
            error_log("Fatal DB error caught: " . $error['message'] . " in " . $error['file'] . ":" . $error['line']);
            
            http_response_code(503);
            echo '<!DOCTYPE html><html><head><title>Service Unavailable</title>';
            echo '<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">';
            echo '<style>body{font-family:"Outfit",sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f8fafc;}';
            echo '.box{text-align:center;padding:60px;max-width:500px;}.box h1{font-size:48px;color:#6366f1;margin:0 0 16px;}.box p{color:#64748b;font-size:18px;line-height:1.6;}';
            echo '.btn{display:inline-block;margin-top:24px;padding:12px 32px;background:#6366f1;color:white;text-decoration:none;border-radius:12px;font-weight:600;}</style></head>';
            echo '<body><div class="box"><h1>⚡ Database Offline</h1>';
            echo '<p>This feature requires a database connection which is currently unavailable. The site is running in preview mode.</p>';
            echo '<a href="/" class="btn">← Back to Home</a></div></body></html>';
            exit;
        }
    }
});

/**
 * Helper: check if database is available before any DB operation.
 * Usage: if (db_ready()) { ... do queries ... }
 */
function db_ready() {
    global $con, $db_connected;
    return ($con && $db_connected);
}
?>