<?php
require_once '../config/config.php';

echo "<h1>Environment Debug</h1>";
echo "<pre>";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_PORT: " . (defined('DB_PORT') ? DB_PORT : 'not defined') . "\n";
echo "DB_NAME: " . DB_NAME . "\n";
echo "DB_USER: " . DB_USER . "\n";
echo "DB_PASS: " . (DB_PASS ? '***set***' : 'empty') . "\n";
echo "</pre>";

echo "<h2>Test Connection</h2>";
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    echo "DSN: $dsn<br>";
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    echo "<span style='color:green'>Connection SUCCESS!</span>";
} catch (Exception $e) {
    echo "<span style='color:red'>Connection FAILED: " . $e->getMessage() . "</span>";
}
