<?php
// Đọc từ environment variables (Railway) hoặc dùng giá trị mặc định (localhost)
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'php_cn');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

// Cấu hình session - giữ session 8 tiếng (28800 giây)
define('SESSION_LIFETIME', 28800);

// Khởi tạo session với thời gian dài hơn
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
    ini_set('session.cookie_lifetime', SESSION_LIFETIME);
    session_start();
}
