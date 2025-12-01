<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Database Connection</h2>";

// Thông tin database InfinityFree
$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

echo "<p>Host: $host</p>";
echo "<p>Database: $dbname</p>";
echo "<p>Username: $username</p>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color:green;font-weight:bold;'>✅ Kết nối database thành công!</p>";
    
    // Test query
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Số users trong database: " . $result['total'] . "</p>";
    
    // Liệt kê users
    $stmt = $pdo->query("SELECT username, full_name, role FROM users LIMIT 10");
    echo "<h3>10 users đầu tiên:</h3><ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>{$row['username']} - {$row['full_name']} ({$row['role']})</li>";
    }
    echo "</ul>";
    
} catch (PDOException $e) {
    echo "<p style='color:red;font-weight:bold;'>❌ Lỗi kết nối: " . $e->getMessage() . "</p>";
}
