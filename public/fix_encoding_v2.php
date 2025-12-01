<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Encoding V2</title></head><body>";
echo "<h2>Fix Database Encoding V2 - Tự động phát hiện và sửa</h2>";

$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
    
    echo "<p style='color:green'>✅ Kết nối thành công!</p>";
    
    // 1. Hiển thị tất cả users hiện tại
    echo "<h3>Danh sách tất cả users trong database:</h3>";
    $stmt = $pdo->query("SELECT user_id, username, full_name, role FROM users ORDER BY role, username");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr style='background:#f0f0f0'><th>ID</th><th>Username</th><th>Full Name (hiện tại)</th><th>Role</th></tr>";
    foreach ($users as $u) {
        $color = (strpos($u['full_name'], '?') !== false) ? 'background:#ffcccc' : '';
        echo "<tr style='$color'>";
        echo "<td>{$u['user_id']}</td>";
        echo "<td>{$u['username']}</td>";
        echo "<td>{$u['full_name']}</td>";
        echo "<td>{$u['role']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<p><em>Các dòng màu đỏ là dữ liệu bị lỗi encoding</em></p>";
    
    // 2. Hiển thị tất cả topics
    echo "<h3>Danh sách đề tài:</h3>";
    $stmt = $pdo->query("SELECT topic_id, title, teacher_id FROM topics ORDER BY topic_id");
    $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr style='background:#f0f0f0'><th>ID</th><th>Title</th><th>Teacher ID</th></tr>";
    foreach ($topics as $t) {
        $color = (strpos($t['title'], '?') !== false) ? 'background:#ffcccc' : '';
        echo "<tr style='$color'>";
        echo "<td>{$t['topic_id']}</td>";
        echo "<td>{$t['title']}</td>";
        echo "<td>{$t['teacher_id']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<h3>⚠️ Để fix encoding, bạn cần import lại dữ liệu từ file SQL với encoding UTF-8 đúng.</h3>";
    echo "<p><a href='/import_fresh.php' style='color:blue;font-size:16px'>→ Import lại database</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "</body></html>";
