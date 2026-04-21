<?php
include('includes/config.php');

echo "<h2>Nexus Elite Database Setup</h2>";

if (db_ready()) {
    echo "<p style='color:green;'>Connected to MySQL successfully!</p>";
    $res = mysqli_query($con, "SHOW TABLES");
    if (mysqli_num_rows($res) > 0) {
        echo "<p>Database already has tables. No action needed.</p>";
    } else {
        echo "<p>Database 'shopping' is empty. Attempting to import backup...</p>";
        import_sql('NexusElite_Final_Backup.sql');
    }
} else {
    echo "<p style='color:red;'>Could not connect to MySQL. Error: " . ($_SESSION['db_error'] ?? 'Unknown error') . "</p>";
    echo "<p>Please ensure:</p>
    <ul>
        <li>XAMPP is running.</li>
        <li>MySQL service is STARTED in XAMPP.</li>
        <li>Database 'shopping' is created in phpMyAdmin.</li>
    </ul>";
}

function import_sql($filename) {
    global $con;
    if (!file_exists($filename)) {
        echo "<p style='color:red;'>Error: $filename not found.</p>";
        return;
    }
    
    // Read the file with UTF-16LE or UTF-8 handling
    $sql_content = file_get_contents($filename);
    // Remove BOM if present
    $sql_content = preg_replace('/^\xEF\xBB\xBF/', '', $sql_content);
    
    $queries = explode(';', $sql_content);
    $success = 0;
    $errors = 0;
    
    foreach ($queries as $query) {
        $query = trim($query);
        if ($query) {
            if (mysqli_query($con, $query)) {
                $success++;
            } else {
                $errors++;
            }
        }
    }
    
    echo "<p>Import complete: $success successful queries, $errors errors.</p>";
    if ($errors == 0) echo "<p style='color:green;'>Database restored successfully!</p>";
}
?>
<a href="index.php">Go to Homepage</a>
