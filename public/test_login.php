<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Login</h2>";

// Kết nối database
$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Lấy user admin
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute(['admin']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<p>User admin tìm thấy:</p>";
        echo "<pre>";
        echo "Username: " . $user['username'] . "\n";
        echo "Password trong DB: " . $user['password'] . "\n";
        echo "Full name: " . $user['full_name'] . "\n";
        echo "Role: " . $user['role'] . "\n";
        echo "</pre>";
        
        // Test password
        $testPass = 'admin123';
        echo "<p>Test password '$testPass':</p>";
        
        // Check plain text
        if ($user['password'] === $testPass) {
            echo "<p style='color:green'>✅ Password khớp (plain text)</p>";
        } else {
            echo "<p style='color:orange'>⚠️ Password không khớp plain text</p>";
        }
        
        // Check password_hash
        if (password_verify($testPass, $user['password'])) {
            echo "<p style='color:green'>✅ Password khớp (hashed)</p>";
        } else {
            echo "<p style='color:orange'>⚠️ Password không khớp hashed</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Không tìm thấy user admin</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
