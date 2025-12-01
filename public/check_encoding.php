<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Check Encoding</title></head><body>";
echo "<h2>Kiểm tra Encoding Database</h2>";

$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
    
    echo "<p style='color:green'>✅ Kết nối thành công!</p>";
    
    // Kiểm tra user 110122028
    echo "<h3>Kiểm tra user 110122028:</h3>";
    $stmt = $pdo->prepare("SELECT user_id, username, full_name, HEX(full_name) as hex_name FROM users WHERE username = ?");
    $stmt->execute(['110122028']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><td>User ID</td><td>{$user['user_id']}</td></tr>";
        echo "<tr><td>Username</td><td>{$user['username']}</td></tr>";
        echo "<tr><td>Full Name</td><td>{$user['full_name']}</td></tr>";
        echo "<tr><td>HEX</td><td>{$user['hex_name']}</td></tr>";
        echo "</table>";
        
        // Kiểm tra encoding
        $expectedHex = bin2hex('Liễu Kiện An');
        echo "<p>Expected HEX cho 'Liễu Kiện An': " . strtoupper($expectedHex) . "</p>";
        
        if (strtoupper($user['hex_name']) === strtoupper($expectedHex)) {
            echo "<p style='color:green'>✅ Encoding đúng!</p>";
        } else {
            echo "<p style='color:red'>❌ Encoding sai! Cần fix.</p>";
            
            // Auto fix
            echo "<h4>Đang fix...</h4>";
            $stmt2 = $pdo->prepare("UPDATE users SET full_name = ? WHERE username = ?");
            $stmt2->execute(['Liễu Kiện An', '110122028']);
            echo "<p style='color:green'>✅ Đã cập nhật thành 'Liễu Kiện An'</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Không tìm thấy user!</p>";
    }
    
    // Hiển thị một số user khác
    echo "<h3>Danh sách 10 users:</h3>";
    $stmt = $pdo->query("SELECT username, full_name FROM users LIMIT 10");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Username</th><th>Full Name</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['username']}</td><td>{$row['full_name']}</td></tr>";
    }
    echo "</table>";
    
    // Hiển thị một số topics
    echo "<h3>Danh sách 5 đề tài:</h3>";
    $stmt = $pdo->query("SELECT topic_id, title FROM topics LIMIT 5");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Title</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['topic_id']}</td><td>{$row['title']}</td></tr>";
    }
    echo "</table>";
    
    echo "<hr>";
    echo "<p><a href='/fix_all_encoding.php'>→ Chạy Fix All Encoding</a></p>";
    echo "<p><a href='/auth/logout'>→ Đăng xuất</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "</body></html>";
