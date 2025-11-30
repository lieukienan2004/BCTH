<?php
echo "<h1>Raw Environment Variables</h1>";
echo "<pre>";
echo "getenv('DB_HOST'): " . var_export(getenv('DB_HOST'), true) . "\n";
echo "getenv('DB_PORT'): " . var_export(getenv('DB_PORT'), true) . "\n";
echo "getenv('DB_NAME'): " . var_export(getenv('DB_NAME'), true) . "\n";
echo "getenv('DB_USER'): " . var_export(getenv('DB_USER'), true) . "\n";
echo "\$_ENV: " . var_export($_ENV, true) . "\n";
echo "\$_SERVER DB vars:\n";
foreach ($_SERVER as $k => $v) {
    if (strpos($k, 'DB_') === 0 || strpos($k, 'MYSQL') === 0) {
        echo "  $k: $v\n";
    }
}
echo "</pre>";

require_once '../config/config.php';

echo "<h1>After Config Load</h1>";
echo "<pre>";
echo "DB_HOST: " . DB_HOST . "\n";
echo "DB_PORT: " . DB_PORT . "\n";
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
