<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<h2>Fix Database Encoding</h2>";

$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
    
    echo "<p style='color:green'>✅ Kết nối thành công!</p>";
    
    // Update các user với tên tiếng Việt đúng
    $updates = [
        ['admin', 'Quản trị viên'],
        ['00248', 'Phạm Minh Đương'],
        ['00249', 'Hà Thị Thúy Vi'],
        ['00250', 'Võ Thành C'],
        ['00251', 'Trịnh Quốc Việt'],
        ['00252', 'Trầm Hoàng Nam'],
        ['00253', 'Đoàn Phước Miền'],
        ['00254', 'Ngô Thanh Huy'],
        ['00255', 'Phạm Thị Trúc Mai'],
        ['00256', 'Lê Thị Thùy Lan'],
        ['00257', 'Nguyễn Mộng Hiền'],
        ['110122028', 'Liễu Kiện An'],
    ];
    
    $stmt = $pdo->prepare("UPDATE users SET full_name = ? WHERE username = ?");
    
    foreach ($updates as $u) {
        $stmt->execute([$u[1], $u[0]]);
        echo "<p>Updated: {$u[0]} -> {$u[1]}</p>";
    }
    
    echo "<p style='color:green;font-weight:bold'>✅ Đã cập nhật encoding!</p>";
    echo "<p><a href='/student'>Quay lại trang chủ</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
