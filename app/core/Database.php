<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $port = defined('DB_PORT') ? DB_PORT : 3306;
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . $port . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ];
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Kết nối không có dbname (dùng cho tạo database)
    public static function getRootConnection(): PDO {
        $port = defined('DB_PORT') ? DB_PORT : 3306;
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . $port . ';charset=utf8mb4';
        return new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }
}

