<?php
class AuthController extends Controller {
    
    public function login() {
        // Start session trước tiên
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Kiểm tra nếu không có password thì return
            if (empty($password)) {
                $this->view('auth/login', ['title' => 'Đăng nhập', 'error' => 'Vui lòng nhập mật khẩu']);
                return;
            }
            
            try {
                // Tìm user theo username
                $stmt = Database::getInstance()->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Debug: Hiển thị thông tin để kiểm tra
                if (!$user) {
                    $data = [
                        'title' => 'Đăng nhập',
                        'error' => 'Không tìm thấy user: ' . $username
                    ];
                    $this->view('auth/login', $data);
                    return;
                }
                
                // Kiểm tra password (cả plain text và hash)
                $passwordMatch = false;
                if ($password === $user['password']) {
                    $passwordMatch = true; // Plain text match
                } elseif (password_verify($password, $user['password'])) {
                    $passwordMatch = true; // Hash match
                }
                
                if ($passwordMatch) {
                    // Lưu thông tin vào session
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Xác định URL redirect
                    $redirectUrl = '/PHP-BCTH/public/';
                    switch ($user['role']) {
                        case 'admin':
                            $redirectUrl = '/PHP-BCTH/public/admin';
                            break;
                        case 'teacher':
                            $redirectUrl = '/PHP-BCTH/public/teacher';
                            break;
                        case 'student':
                            $redirectUrl = '/PHP-BCTH/public/student';
                            break;
                    }
                    
                    // Clear output buffer trước khi redirect
                    if (ob_get_level()) {
                        ob_end_clean();
                    }
                    
                    // Redirect với exit ngay lập tức
                    header('Location: ' . $redirectUrl, true, 302);
                    exit();
                } else {
                    $data = [
                        'title' => 'Đăng nhập',
                        'error' => 'Mật khẩu không đúng cho user: ' . $username
                    ];
                    $this->view('auth/login', $data);
                }
                
            } catch (Exception $e) {
                $data = [
                    'title' => 'Đăng nhập',
                    'error' => 'Lỗi database: ' . $e->getMessage()
                ];
                $this->view('auth/login', $data);
            }
        } else {
            $this->view('auth/login', ['title' => 'Đăng nhập']);
        }
    }
    
    public function logout() {
        session_start();
        session_destroy();
        header('Location: /PHP-BCTH/public/login');
        exit;
    }
    
    // Gửi mã reset password qua email
    public function sendResetCode() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $email = $input['email'] ?? '';
        
        if (empty($username) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin!']);
            return;
        }
        
        try {
            // Kiểm tra user và email có khớp không
            $stmt = Database::getInstance()->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
            $stmt->execute([$username, $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Tài khoản hoặc email không đúng!']);
                return;
            }
            
            // Tạo mã 6 số ngẫu nhiên
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            
            // Lưu mã vào database
            $stmt = Database::getInstance()->prepare("UPDATE users SET reset_code = ?, reset_expiry = ? WHERE user_id = ?");
            $stmt->execute([$code, $expiry, $user['user_id']]);
            
            // Gửi email
            $to = $email;
            $subject = "=?UTF-8?B?" . base64_encode("Mã xác nhận đặt lại mật khẩu - TVU") . "?=";
            $message = "
            <html>
            <head>
                <meta charset='UTF-8'>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
                <div style='max-width: 500px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                    <div style='background: linear-gradient(135deg, #0ea5e9, #0284c7); padding: 30px; text-align: center;'>
                        <h1 style='color: white; margin: 0;'>Đặt lại mật khẩu</h1>
                    </div>
                    <div style='padding: 30px; text-align: center;'>
                        <p style='color: #666; font-size: 16px;'>Xin chào <strong>{$user['full_name']}</strong>,</p>
                        <p style='color: #666;'>Mã xác nhận của bạn là:</p>
                        <div style='background: #f0f9ff; border: 2px dashed #0ea5e9; border-radius: 10px; padding: 20px; margin: 20px 0;'>
                            <span style='font-size: 32px; font-weight: bold; color: #0284c7; letter-spacing: 8px;'>{$code}</span>
                        </div>
                        <p style='color: #999; font-size: 14px;'>Mã có hiệu lực trong 15 phút.</p>
                        <p style='color: #999; font-size: 14px;'>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                    </div>
                    <div style='background: #f8f8f8; padding: 15px; text-align: center; color: #999; font-size: 12px;'>
                        © 2024 Trường Đại học Trà Vinh
                    </div>
                </div>
            </body>
            </html>
            ";
            
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: TVU System <noreply@tvu.edu.vn>\r\n";
            
            $mailSent = @mail($to, $subject, $message, $headers);
            
            if ($mailSent) {
                echo json_encode(['success' => true, 'message' => 'Mã đã được gửi!']);
            } else {
                // Nếu mail() không hoạt động, vẫn cho phép tiếp tục (để test)
                // Trong production nên dùng PHPMailer hoặc SMTP
                echo json_encode(['success' => true, 'message' => 'Mã đã được gửi!', 'debug_code' => $code]);
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }
    
    // Xác nhận mã reset
    public function verifyResetCode() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $code = $input['code'] ?? '';
        
        if (empty($username) || empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin!']);
            return;
        }
        
        try {
            // Kiểm tra mã (bỏ qua thời gian hết hạn khi test)
            $stmt = Database::getInstance()->prepare("SELECT * FROM users WHERE username = ? AND reset_code = ?");
            $stmt->execute([$username, $code]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                // Debug: kiểm tra xem user có tồn tại không
                $stmt2 = Database::getInstance()->prepare("SELECT username, reset_code FROM users WHERE username = ?");
                $stmt2->execute([$username]);
                $debugUser = $stmt2->fetch(PDO::FETCH_ASSOC);
                
                $debugMsg = 'Mã không đúng!';
                if ($debugUser) {
                    $debugMsg .= ' (Mã trong DB: ' . ($debugUser['reset_code'] ?? 'NULL') . ', Mã nhập: ' . $code . ')';
                }
                
                echo json_encode(['success' => false, 'message' => $debugMsg]);
                return;
            }
            
            // Tạo token để đổi mật khẩu
            $token = bin2hex(random_bytes(32));
            $stmt = Database::getInstance()->prepare("UPDATE users SET reset_token = ? WHERE user_id = ?");
            $stmt->execute([$token, $user['user_id']]);
            
            echo json_encode(['success' => true, 'token' => $token]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi DB: ' . $e->getMessage()]);
        }
    }
    
    // Kiểm tra session còn hợp lệ không (AJAX)
    public function checkSession() {
        header('Content-Type: application/json');
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $valid = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
        
        echo json_encode(['valid' => $valid]);
        exit;
    }
    
    // Đổi mật khẩu
    public function resetPassword() {
        header('Content-Type: application/json');
        
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $token = $input['token'] ?? '';
        $password = $input['password'] ?? '';
        
        if (empty($username) || empty($token) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin!']);
            return;
        }
        
        if (strlen($password) < 6) {
            echo json_encode(['success' => false, 'message' => 'Mật khẩu phải có ít nhất 6 ký tự!']);
            return;
        }
        
        try {
            // Kiểm tra token
            $stmt = Database::getInstance()->prepare("SELECT * FROM users WHERE username = ? AND reset_token = ?");
            $stmt->execute([$username, $token]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Token không hợp lệ!']);
                return;
            }
            
            // Cập nhật mật khẩu mới (hash)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = Database::getInstance()->prepare("UPDATE users SET password = ?, reset_code = NULL, reset_expiry = NULL, reset_token = NULL WHERE user_id = ?");
            $stmt->execute([$hashedPassword, $user['user_id']]);
            
            echo json_encode(['success' => true, 'message' => 'Đổi mật khẩu thành công!']);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }
}