<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8');

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Fix Encoding</title></head><body>";
echo "<h2>Fix All Database Encoding</h2>";

$host = 'sql303.infinityfree.com';
$dbname = 'if0_40563805_bcth';
$username = 'if0_40563805';
$password = 'SwXe3BqDD5Tvx';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET character_set_connection=utf8mb4");
    
    echo "<p style='color:green'>✅ Kết nối thành công!</p>";
    
    // Kiểm tra và fix collation của database và tables
    echo "<h3>1. Kiểm tra và fix collation:</h3>";
    
    // Fix database collation
    $pdo->exec("ALTER DATABASE `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✓ Database collation: utf8mb4_unicode_ci</p>";
    
    // Fix tables collation
    $tables = ['users', 'topics', 'registrations', 'progress', 'notifications', 'messages', 'documents'];
    foreach ($tables as $table) {
        try {
            $pdo->exec("ALTER TABLE `$table` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "<p>✓ Table $table: utf8mb4_unicode_ci</p>";
        } catch (Exception $e) {
            echo "<p style='color:orange'>⚠ Table $table: " . $e->getMessage() . "</p>";
        }
    }
    
    // Danh sách giảng viên
    echo "<h3>2. Cập nhật giảng viên:</h3>";
    $teachers = [
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
        ['00258', 'Nhan Minh Phúc'],
        ['00259', 'Trịnh Thị Anh Duyên'],
        ['00260', 'Đặng Hữu Phúc'],
        ['00261', 'Trần Song Toàn'],
        ['00262', 'Phạm Minh Triết'],
        ['00264', 'Nguyễn Thanh Tần'],
        ['00265', 'Trần Thị Sen'],
        ['00267', 'Phan Văn Tuân'],
        ['00268', 'Trương Văn Mến'],
        ['00269', 'Dương Minh Hùng'],
        ['00696', 'Lê Minh Hải'],
        ['00707', 'Nguyễn Phú Nhuận'],
        ['00823', 'Thạch Vũ Đình Vi'],
        ['02405', 'Nguyễn Thanh Hiền'],
        ['03539', 'Lê Minh Tự'],
        ['03546', 'Phan Thị Phương Nam'],
        ['03562', 'Nguyễn Khắc Quốc'],
        ['06742', 'Ngô Thanh Hà'],
        ['10101', 'Hồ Ngọc Hà'],
        ['12661', 'Võ Phước Hưng'],
        ['12692', 'Đặng Hoàng Minh'],
        ['12694', 'Lê Thanh Tùng'],
        ['12695', 'Nguyễn Ngọc Tiền'],
        ['12696', 'Thạch Thị Viasana'],
        ['12700', 'Khấu Văn Nhựt'],
        ['12701', 'Trần Văn Nam'],
        ['12702', 'Nguyễn Thừa Phát Tài'],
        ['12703', 'Nguyễn Hoàng Vũ'],
        ['12704', 'Kim Anh Tuấn'],
        ['12705', 'Nguyễn Trần Diễm Hạnh'],
    ];
    
    $stmt = $pdo->prepare("UPDATE users SET full_name = ? WHERE username = ?");
    $count = 0;
    foreach ($teachers as $u) {
        $stmt->execute([$u[1], $u[0]]);
        if ($stmt->rowCount() > 0) {
            echo "<p>✓ {$u[0]} → {$u[1]}</p>";
            $count++;
        }
    }
    echo "<p><strong>Đã cập nhật $count giảng viên</strong></p>";
    
    // Danh sách sinh viên
    echo "<h3>3. Cập nhật sinh viên:</h3>";
    $students = [
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
        ['110122064', 'Trương Mỹ Duyên'],
        ['110122062', 'Nguyễn Thanh Duy'],
        ['110122061', 'Nguyễn Lê Duy'],
        ['110122060', 'Lê Hà Duy'],
        ['110122059', 'Huỳnh Khánh Duy'],
        ['110122058', 'Đào Công Duy'],
        ['110122056', 'Hồ Nguyễn Quốc Dũng'],
        ['110122028', 'Liễu Kiện An'],
        ['110122101', 'Phùng Quốc Kiệt'],
        ['110122100', 'Huỳnh Quốc Kiệt'],
        ['110122099', 'Hoàng Tuấn Kiệt'],
        ['110122098', 'Đặng Gia Kiệt'],
        ['110122097', 'Nguyễn Minh Khởi'],
        ['110122095', 'Nguyễn Ngọc Anh Khoa'],
        ['110122094', 'Nguyễn Đinh Tuấn Khoa'],
        ['110122093', 'Hồ Anh Khoa'],
        ['110122092', 'Ngô Huỳnh Quốc Khang'],
        ['110122090', 'La Thuấn Khang'],
        ['110122089', 'Phan Đình Khải'],
        ['110122087', 'Trầm Tấn Khá'],
        ['110122086', 'Lê Tuấn Kha'],
        ['110122083', 'Đỗ Thị Kim Hương'],
        ['110122082', 'Châu Thị Mỹ Hương'],
        ['110122081', 'Trần Tấn Hưng'],
        ['110122079', 'Nguyễn Phi Hùng'],
        ['110122078', 'Nguyễn Văn Hoàng'],
        ['110122077', 'Huỳnh Minh Khải Hoàn'],
        ['110122001', 'Nguyễn Văn A'],
        ['110122002', 'Trần Thị B'],
        ['110122003', 'Lê Văn C'],
        ['110122004', 'Phạm Thị D'],
        ['110122005', 'Hoàng Văn E'],
    ];
    
    $count = 0;
    foreach ($students as $u) {
        $stmt->execute([$u[1], $u[0]]);
        if ($stmt->rowCount() > 0) {
            echo "<p>✓ {$u[0]} → {$u[1]}</p>";
            $count++;
        }
    }
    echo "<p><strong>Đã cập nhật $count sinh viên</strong></p>";
    
    // Fix topics
    echo "<h3>4. Cập nhật đề tài:</h3>";
    $topics = [
        [1, 'Xây dựng ứng dụng quản lý thư viện trực tuyến', 'Phát triển hệ thống quản lý thư viện với các chức năng: quản lý sách, mượn trả sách, tìm kiếm, thống kê.', 'Biết lập trình PHP, MySQL cơ bản'],
        [2, 'Ứng dụng học tập trực tuyến với AI', 'Xây dựng nền tảng học tập tích hợp AI để gợi ý khóa học, đánh giá tiến độ học tập.', 'Có kiến thức về Machine Learning'],
        [3, 'Hệ thống quản lý bán hàng và kho', 'Phát triển phần mềm quản lý bán hàng, nhập xuất kho, báo cáo doanh thu.', 'Biết lập trình web cơ bản'],
        [4, 'Website thương mại điện tử với thanh toán online', 'Xây dựng website bán hàng tích hợp thanh toán VNPay, Momo.', 'Có kiến thức về API thanh toán'],
        [5, 'Ứng dụng di động quản lý chi tiêu cá nhân', 'Phát triển app mobile giúp người dùng theo dõi thu chi, lập ngân sách.', 'Biết React Native hoặc Flutter'],
        [6, 'Hệ thống IoT giám sát môi trường', 'Xây dựng hệ thống giám sát nhiệt độ, độ ẩm, chất lượng không khí sử dụng cảm biến.', 'Có kiến thức về Arduino/ESP32'],
        [7, 'Chatbot hỗ trợ tư vấn tuyển sinh', 'Phát triển chatbot AI để tư vấn thông tin tuyển sinh cho sinh viên.', 'Biết về NLP và xử lý ngôn ngữ tự nhiên'],
        [8, 'Game giáo dục cho trẻ em', 'Phát triển game học toán, tiếng Anh cho trẻ tiểu học với giao diện thân thiện.', 'Có kiến thức về Unity hoặc Godot'],
        [9, 'Hệ thống nhận diện khuôn mặt điểm danh', 'Xây dựng hệ thống điểm danh tự động bằng nhận diện khuôn mặt cho lớp học.', 'Biết về Computer Vision, OpenCV'],
        [10, 'Website tin tức với CMS tùy chỉnh', 'Phát triển website tin tức có hệ thống quản lý nội dung linh hoạt.', 'Biết lập trình PHP/Laravel'],
    ];
    
    $stmtTopic = $pdo->prepare("UPDATE topics SET title = ?, description = ?, requirements = ? WHERE topic_id = ?");
    $count = 0;
    foreach ($topics as $t) {
        $stmtTopic->execute([$t[1], $t[2], $t[3], $t[0]]);
        if ($stmtTopic->rowCount() > 0) {
            echo "<p>✓ Đề tài {$t[0]}: {$t[1]}</p>";
            $count++;
        }
    }
    echo "<p><strong>Đã cập nhật $count đề tài</strong></p>";
    
    echo "<hr>";
    echo "<p style='color:green;font-weight:bold;font-size:20px'>✅ HOÀN TẤT! Đã fix encoding cho toàn bộ database.</p>";
    echo "<p><a href='/student/topics' style='color:blue;font-size:16px;text-decoration:underline'>→ Xem trang Danh sách đề tài</a></p>";
    echo "<p><a href='/student' style='color:blue;font-size:16px;text-decoration:underline'>→ Quay lại trang chủ</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Lỗi: " . $e->getMessage() . "</p>";
}

echo "</body></html>";
