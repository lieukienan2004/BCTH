<?php
// Helper function để đọc env vars
function env($key, $default = '') {
    if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
        return $_ENV[$key];
    }
    if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
        return $_SERVER[$key];
    }
    $val = getenv($key);
    if ($val !== false && $val !== '') {
        return $val;
    }
    return $default;
}

// Detect hosting environment
$host = $_SERVER['HTTP_HOST'] ?? '';
$isInfinityFreeHost = strpos($host, 'kesug.com') !== false || strpos($host, 'epizy.com') !== false;

if ($isInfinityFreeHost && file_exists(__DIR__ . '/infinityfree.php')) {
    // Load cấu hình InfinityFree
    require_once __DIR__ . '/infinityfree.php';
} else {
    // Đọc từ environment variables (Railway) hoặc dùng giá trị mặc định (localhost)
    define('DB_HOST', env('DB_HOST', 'localhost'));
    define('DB_PORT', env('DB_PORT', '3306'));
    define('DB_NAME', env('DB_NAME', 'php_cn'));
    define('DB_USER', env('DB_USER', 'root'));
    define('DB_PASS', env('DB_PASS', ''));
}

// Cấu hình session - giữ session 8 tiếng (28800 giây)
define('SESSION_LIFETIME', 28800);

// Detect môi trường và định nghĩa BASE_PATH
$host = $_SERVER['HTTP_HOST'] ?? '';
$isRailway = strpos($host, 'railway.app') !== false;
$isInfinityFree = strpos($host, 'kesug.com') !== false || strpos($host, 'epizy.com') !== false || strpos($host, 'infinityfree') !== false;

if ($isRailway || $isInfinityFree) {
    define('BASE_PATH', '');
} else {
    define('BASE_PATH', '/PHP-BCTH/public');
}

// Helper function để tạo URL
function url($path = '') {
    return BASE_PATH . $path;
}

// Khởi tạo session với thời gian dài hơn
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', SESSION_LIFETIME);
    ini_set('session.cookie_lifetime', SESSION_LIFETIME);
    
    // Cấu hình cookie cho Railway (HTTPS)
    if ($isRailway) {
        ini_set('session.cookie_secure', '1');
        ini_set('session.cookie_samesite', 'Lax');
    }
    
    session_start();
}
