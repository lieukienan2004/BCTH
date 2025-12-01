-- Fix encoding cho database
-- Chạy file này trong phpMyAdmin

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Xóa dữ liệu cũ
DELETE FROM topics;
DELETE FROM users;

-- Insert lại admin
INSERT INTO users (username, password, full_name, email, role) 
VALUES ('admin', 'admin123', 'Quản trị viên', 'admin@tvu.edu.vn', 'admin');

-- Insert giảng viên
INSERT INTO users (username, password, full_name, email, role, student_code) VALUES
('00248', '00248', 'Phạm Minh Đương', '00248@tvu.edu.vn', 'teacher', '00248'),
('00249', '00249', 'Hà Thị Thúy Vi', '00249@tvu.edu.vn', 'teacher', '00249'),
('00250', '00250', 'Võ Thành C', '00250@tvu.edu.vn', 'teacher', '00250'),
('00251', '00251', 'Trịnh Quốc Việt', '00251@tvu.edu.vn', 'teacher', '00251'),
('00252', '00252', 'Trầm Hoàng Nam', '00252@tvu.edu.vn', 'teacher', '00252'),
('00253', '00253', 'Đoàn Phước Miền', '00253@tvu.edu.vn', 'teacher', '00253'),
('00254', '00254', 'Ngô Thanh Huy', '00254@tvu.edu.vn', 'teacher', '00254'),
('00255', '00255', 'Phạm Thị Trúc Mai', '00255@tvu.edu.vn', 'teacher', '00255'),
('00256', '00256', 'Lê Thị Thùy Lan', '00256@tvu.edu.vn', 'teacher', '00256'),
('00257', '00257', 'Nguyễn Mộng Hiền', '00257@tvu.edu.vn', 'teacher', '00257');

-- Insert sinh viên
INSERT INTO users (username, password, full_name, email, role, student_code) VALUES
('110122028', '110122028', 'Liễu Kiện An', '110122028@sv.tvu.edu.vn', 'student', '110122028'),
('110122001', '110122001', 'Nguyễn Văn A', '110122001@sv.tvu.edu.vn', 'student', '110122001'),
('110122002', '110122002', 'Trần Thị B', '110122002@sv.tvu.edu.vn', 'student', '110122002');

-- Insert đề tài
INSERT INTO topics (teacher_id, title, description, requirements, max_students, status) VALUES
((SELECT user_id FROM users WHERE username = '00248'), 
 'Xây dựng ứng dụng quản lý thư viện trực tuyến', 
 'Phát triển hệ thống quản lý thư viện với các chức năng: quản lý sách, mượn trả sách, tìm kiếm, thống kê.',
 'Kiến thức: PHP/Laravel hoặc Node.js, MySQL, HTML/CSS/JavaScript.',
 12, 'approved'),

((SELECT user_id FROM users WHERE username = '00248'), 
 'Ứng dụng học tập trực tuyến với AI',
 'Xây dựng nền tảng học tập tích hợp AI để gợi ý khóa học, đánh giá tiến độ học tập.',
 'Kiến thức: Python, Machine Learning cơ bản, Web framework.',
 12, 'approved'),

((SELECT user_id FROM users WHERE username = '00249'), 
 'Hệ thống quản lý bán hàng và kho',
 'Phát triển phần mềm quản lý bán hàng, nhập xuất kho, báo cáo doanh thu cho cửa hàng nhỏ.',
 'Kiến thức: Java/C#, SQL Server/MySQL, Desktop application.',
 12, 'approved'),

((SELECT user_id FROM users WHERE username = '00249'), 
 'Website thương mại điện tử với thanh toán online',
 'Xây dựng website bán hàng tích hợp thanh toán VNPay, Momo, quản lý đơn hàng.',
 'Kiến thức: PHP/Laravel, MySQL, Payment Gateway API.',
 12, 'approved'),

((SELECT user_id FROM users WHERE username = '00250'), 
 'Ứng dụng di động quản lý chi tiêu cá nhân',
 'Phát triển app mobile giúp người dùng theo dõi thu chi, lập kế hoạch tài chính.',
 'Kiến thức: React Native hoặc Flutter, Firebase/SQLite.',
 12, 'approved'),

((SELECT user_id FROM users WHERE username = '00251'), 
 'Hệ thống IoT giám sát môi trường',
 'Xây dựng hệ thống giám sát nhiệt độ, độ ẩm, chất lượng không khí sử dụng Arduino/ESP32.',
 'Kiến thức: Arduino/ESP32, MQTT, Web Node.js/Python.',
 12, 'approved');

SELECT 'Done! Data imported with UTF-8 encoding' as status;
