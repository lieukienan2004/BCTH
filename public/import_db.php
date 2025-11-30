<?php
require_once '../config/config.php';

echo "<h1>Import Database</h1>";

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database.<br>";
    
    // Read SQL file
    $sqlFile = '../db/php_cn.sql';
    $sql = file_get_contents($sqlFile);
    
    if ($sql === false) {
        die("Cannot read SQL file");
    }
    
    // Replace placeholder with actual database name
    $sql = str_replace('{{DB_NAME}}', DB_NAME, $sql);
    // Remove USE statement since we're already connected to the database
    $sql = preg_replace('/USE\s+\w+;/i', '', $sql);
    
    echo "SQL file loaded and processed (" . strlen($sql) . " bytes).<br>";
    
    // Execute SQL
    $pdo->exec($sql);
    
    echo "<span style='color:green;font-size:20px'>Database imported successfully!</span><br>";
    
    // Show tables
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<h2>Tables created:</h2><ul>";
    foreach ($tables as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
        echo "<li>$table ($count rows)</li>";
    }
    echo "</ul>";
    
} catch (Exception $e) {
    echo "<span style='color:red'>Error: " . $e->getMessage() . "</span>";
}
