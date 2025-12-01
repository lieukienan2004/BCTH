<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<h2>Import Fresh Database với UTF-8</h2>";

$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    
    echo "<p style='color:green'>✅ Kết nối thành công!</p>";
    
    // Drop all tables
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $tables = ['activity_logs','sessions','submissions','progress_reports','notifications','registrations','topics','time_settings','users'];
    foreach ($tables as $t) {
        $pdo->exec("DROP TABLE IF EXISTS $t");
        echo "<p>Dropped: $t</p>";
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    
    echo "<p><strong>Tạo tables...</strong></p>";
    
    // Create users table
    $pdo->exec("CREATE TABLE users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        role ENUM('admin','teacher','student') NOT NULL DEFAULT 'student',
        student_code VARCHAR(50) UNIQUE,
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        last_login TIMESTAMP NULL,
        reset_code VARCHAR(10) NULL,
        reset_expiry DATETIME NULL,
        reset_token VARCHAR(255) NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

    echo "<p>✓ Created: users</p>";
    
    // Create other tables
    $pdo->exec("CREATE TABLE time_settings (
        setting_id INT AUTO_INCREMENT PRIMARY KEY,
        setting_name VARCHAR(100) NOT NULL,
        start_date DATETIME NOT NULL,
        end_date DATETIME NOT NULL,
        description TEXT,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: time_settings</p>";
    
    $pdo->exec("CREATE TABLE topics (
        topic_id INT AUTO_INCREMENT PRIMARY KEY,
        teacher_id INT NOT NULL,
        title VARCHAR(500) NOT NULL,
        description TEXT,
        requirements TEXT,
        max_students INT DEFAULT 12,
        current_students INT DEFAULT 0,
        status ENUM('pending','approved','rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (teacher_id) REFERENCES users(user_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: topics</p>";
    
    $pdo->exec("CREATE TABLE registrations (
        registration_id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL,
        topic_id INT NOT NULL,
        status ENUM('pending','approved','rejected') DEFAULT 'pending',
        registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        approved_at TIMESTAMP NULL,
        FOREIGN KEY (student_id) REFERENCES users(user_id) ON DELETE CASCADE,
        FOREIGN KEY (topic_id) REFERENCES topics(topic_id) ON DELETE CASCADE,
        UNIQUE KEY unique_student_topic (student_id, topic_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: registrations</p>";
    
    $pdo->exec("CREATE TABLE progress_reports (
        report_id INT AUTO_INCREMENT PRIMARY KEY,
        registration_id INT NOT NULL,
        week_number INT NOT NULL,
        task_name VARCHAR(500) NOT NULL,
        status ENUM('completed','incomplete') DEFAULT 'incomplete',
        note TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (registration_id) REFERENCES registrations(registration_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: progress_reports</p>";

    $pdo->exec("CREATE TABLE notifications (
        notification_id INT AUTO_INCREMENT PRIMARY KEY,
        sender_id INT NOT NULL,
        receiver_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        is_read BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        read_at TIMESTAMP NULL,
        FOREIGN KEY (sender_id) REFERENCES users(user_id) ON DELETE CASCADE,
        FOREIGN KEY (receiver_id) REFERENCES users(user_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: notifications</p>";
    
    $pdo->exec("CREATE TABLE submissions (
        submission_id INT AUTO_INCREMENT PRIMARY KEY,
        registration_id INT NOT NULL,
        google_drive_link VARCHAR(500),
        github_link VARCHAR(500),
        note TEXT,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (registration_id) REFERENCES registrations(registration_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: submissions</p>";
    
    $pdo->exec("CREATE TABLE sessions (
        session_id VARCHAR(128) PRIMARY KEY,
        user_id INT,
        ip_address VARCHAR(45),
        user_agent VARCHAR(255),
        last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: sessions</p>";
    
    $pdo->exec("CREATE TABLE activity_logs (
        log_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        action VARCHAR(100) NOT NULL,
        table_name VARCHAR(50),
        record_id INT,
        old_value TEXT,
        new_value TEXT,
        ip_address VARCHAR(45),
        user_agent VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    echo "<p>✓ Created: activity_logs</p>";
    
    echo "<p><strong>Insert dữ liệu...</strong></p>";

    // Insert admin
    $pdo->exec("INSERT INTO users (username, password, full_name, email, role) VALUES 
        ('admin', 'admin123', 'Quản trị viên', 'admin@tvu.edu.vn', 'admin')");
    echo "<p>✓ Admin created</p>";
    
    // Insert teachers
    $teachers = [
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
    ];
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, email, role, student_code) VALUES (?, ?, ?, ?, 'teacher', ?)");
    foreach ($teachers as $t) {
        $stmt->execute([$t[0], $t[0], $t[1], $t[0].'@tvu.edu.vn', $t[0]]);
    }
    echo "<p>✓ Teachers created: " . count($teachers) . "</p>";
    
    // Insert students
    $students = [
        ['110122028', 'Liễu Kiện An'],
        ['110122064', 'Trương Mỹ Duyên'],
        ['110122249', 'Lâm Tinh Tú'],
        ['110122248', 'Nguyễn Thanh Triệu'],
        ['110122246', 'Trần Thanh Thưởng'],
        ['110122243', 'Phạm Duy Tân'],
        ['110122106', 'Mai Hồng Lợi'],
        ['110122105', 'Nguyễn Đỗ Thành Lộc'],
        ['110122103', 'Hà Gia Lộc'],
        ['110122102', 'Nguyễn Hoàng Lăm'],
        ['110122076', 'Phạm Trung Hiếu'],
        ['110122075', 'Đặng Minh Hiếu'],
        ['110122074', 'Đàm Thúy Hiền'],
        ['110122069', 'Nguyễn Thị Ngọc Hân'],
        ['110122071', 'Lâm Nhật Hào'],
        ['110122070', 'Đỗ Gia Hào'],
        ['110122068', 'Võ Chí Hải'],
        ['110122066', 'Trương Hoàng Giang'],
        ['110122055', 'Trần Minh Đức'],
        ['110122054', 'Trần Lâm Phú Đức'],
    ];
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, full_name, email, role, student_code) VALUES (?, ?, ?, ?, 'student', ?)");
    foreach ($students as $s) {
        $stmt->execute([$s[0], $s[0], $s[1], $s[0].'@sv.tvu.edu.vn', $s[0]]);
    }
    echo "<p>✓ Students created: " . count($students) . "</p>";

    // Insert topics
    $pdo->exec("INSERT INTO topics (teacher_id, title, description, requirements, max_students, status) VALUES 
        ((SELECT user_id FROM users WHERE username='00248'), 'Xây dựng ứng dụng quản lý thư viện trực tuyến', 'Phát triển hệ thống quản lý thư viện với các chức năng: quản lý sách, mượn trả sách, tìm kiếm, thống kê.', 'Kiến thức: PHP/Laravel hoặc Node.js, MySQL.', 12, 'approved'),
        ((SELECT user_id FROM users WHERE username='00248'), 'Ứng dụng học tập trực tuyến với AI', 'Xây dựng nền tảng học tập tích hợp AI để gợi ý khóa học.', 'Kiến thức: Python, Machine Learning.', 12, 'approved'),
        ((SELECT user_id FROM users WHERE username='00249'), 'Hệ thống quản lý bán hàng và kho', 'Phát triển phần mềm quản lý bán hàng, nhập xuất kho.', 'Kiến thức: Java/C#, SQL Server.', 12, 'approved'),
        ((SELECT user_id FROM users WHERE username='00249'), 'Website thương mại điện tử', 'Xây dựng website bán hàng tích hợp thanh toán online.', 'Kiến thức: PHP/Laravel, MySQL.', 12, 'approved'),
        ((SELECT user_id FROM users WHERE username='00250'), 'Ứng dụng quản lý chi tiêu cá nhân', 'App mobile giúp theo dõi thu chi, lập kế hoạch tài chính.', 'Kiến thức: React Native hoặc Flutter.', 12, 'approved'),
        ((SELECT user_id FROM users WHERE username='00251'), 'Hệ thống IoT giám sát môi trường', 'Giám sát nhiệt độ, độ ẩm, chất lượng không khí.', 'Kiến thức: Arduino/ESP32, MQTT.', 12, 'approved')
    ");
    echo "<p>✓ Topics created</p>";
    
    // Insert time_settings
    $pdo->exec("INSERT INTO time_settings (setting_name, start_date, end_date, description, is_active) VALUES
        ('Thời gian đăng ký đề tài', '2024-01-15 00:00:00', '2025-12-31 23:59:59', 'Sinh viên đăng ký đề tài', 1),
        ('Thời gian báo cáo tiến độ', '2024-01-22 00:00:00', '2025-12-31 23:59:59', 'Cập nhật báo cáo tiến độ', 1),
        ('Thời gian nộp bài', '2024-03-01 00:00:00', '2025-12-31 23:59:59', 'Nộp bài đồ án', 1)
    ");
    echo "<p>✓ Time settings created</p>";
    
    echo "<h2 style='color:green'>✅ Import thành công!</h2>";
    echo "<p><a href='/student' style='font-size:18px'>👉 Vào trang sinh viên</a></p>";
    echo "<p><a href='/login' style='font-size:18px'>👉 Đăng nhập</a></p>";
    echo "<p>Admin: admin / admin123</p>";
    echo "<p>Sinh viên: 110122028 / 110122028</p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}
?>
