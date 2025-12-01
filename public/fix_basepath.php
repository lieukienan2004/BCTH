<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix BasePath</title></head><body>";
echo "<h2>Fix BasePath cho tất cả views</h2>";

$fixes = 0;

// Danh sách các file cần fix
$files = [
    '../app/views/auth/login.php',
];

$oldCode = '<?php 
$basePath = (strpos($_SERVER[\'HTTP_HOST\'] ?? \'\', \'railway.app\') !== false) ? \'\' : \'/PHP-BCTH/public\';
?>';

$newCode = '<?php 
$host = $_SERVER[\'HTTP_HOST\'] ?? \'\';
$isProduction = strpos($host, \'railway.app\') !== false || strpos($host, \'kesug.com\') !== false || strpos($host, \'epizy.com\') !== false;
$basePath = $isProduction ? \'\' : \'/PHP-BCTH/public\';
?>';

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        if (strpos($content, $oldCode) !== false) {
            $content = str_replace($oldCode, $newCode, $content);
            file_put_contents($file, $content);
            echo "<p style='color:green'>✅ Fixed: $file</p>";
            $fixes++;
        } elseif (strpos($content, 'kesug.com') !== false) {
            echo "<p style='color:blue'>ℹ️ Already fixed: $file</p>";
        } else {
            echo "<p style='color:orange'>⚠️ Pattern not found in: $file</p>";
            
            // Thử fix bằng cách khác - tìm và thay thế pattern tương tự
            $pattern = '/\$basePath\s*=\s*\(strpos\(\$_SERVER\[.HTTP_HOST.\].*?railway\.app.*?\).*?;/s';
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, 
                    '$host = $_SERVER[\'HTTP_HOST\'] ?? \'\';
$isProduction = strpos($host, \'railway.app\') !== false || strpos($host, \'kesug.com\') !== false || strpos($host, \'epizy.com\') !== false;
$basePath = $isProduction ? \'\' : \'/PHP-BCTH/public\';', 
                    $content);
                file_put_contents($file, $content);
                echo "<p style='color:green'>✅ Fixed with regex: $file</p>";
                $fixes++;
            }
        }
    } else {
        echo "<p style='color:red'>❌ File not found: $file</p>";
    }
}

// Kiểm tra kết quả
echo "<hr>";
echo "<h3>Kiểm tra file login.php:</h3>";
$loginFile = '../app/views/auth/login.php';
if (file_exists($loginFile)) {
    $content = file_get_contents($loginFile);
    
    // Tìm phần basePath
    if (preg_match('/\$basePath.*?;/s', $content, $match)) {
        echo "<pre style='background:#f0f0f0;padding:10px;'>" . htmlspecialchars(substr($content, 0, 800)) . "</pre>";
    }
    
    if (strpos($content, 'kesug.com') !== false) {
        echo "<p style='color:green;font-size:18px'>✅ File đã có kesug.com!</p>";
    } else {
        echo "<p style='color:red;font-size:18px'>❌ File chưa có kesug.com - cần fix thủ công</p>";
    }
}

echo "<hr>";
echo "<p><a href='/login' style='font-size:18px'>→ Test trang Login</a></p>";
echo "<p><a href='/auth/logout' style='font-size:18px'>→ Logout</a></p>";

echo "</body></html>";
