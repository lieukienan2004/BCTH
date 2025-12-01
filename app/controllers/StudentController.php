<?php
class StudentController extends Controller {
    
    private function checkStudentSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Detect environment - Railway hoặc localhost
        $basePath = (strpos($_SERVER['HTTP_HOST'] ?? '', 'railway.app') !== false) ? '' : '/PHP-BCTH/public';
        
        // Kiểm tra session hết hạn hoặc chưa đăng nhập
        if (!isset($_SESSION['user_id'])) {
            // Xóa toàn bộ session cũ
            session_unset();
            session_destroy();
            
            // Bắt đầu session mới để lưu thông báo lỗi
            session_start();
            $_SESSION['error'] = 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.';
            header('Location: ' . $basePath . '/auth/login');
            exit;
        }
        
        // Kiểm tra role - redirect về trang phù hợp nếu không phải student
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
            $role = $_SESSION['role'] ?? '';
            
            // Redirect về trang phù hợp với role hiện tại
            switch ($role) {
                case 'teacher':
                    header('Location: ' . $basePath . '/teacher');
                    break;
                case 'admin':
                    header('Location: ' . $basePath . '/admin');
                    break;
                default:
                    header('Location: ' . $basePath . '/auth/login');
            }
            exit;
        }
        
        // Refresh session để kéo dài thời gian
        $_SESSION['last_activity'] = time();
        
        return $_SESSION['user_id'];
    }
    
    public function index() {
        $userId = $this->checkStudentSession();
        $topicModel = $this->model('Topic');
        $registrationModel = $this->model('Registration');
        $notificationModel = $this->model('Notification');
        
        $data = [
            'title' => 'Trang chủ sinh viên',
            'available_topics' => $topicModel->getAvailableTopics(),
            'my_registration' => $registrationModel->getByStudentId($userId),
            'notifications' => $notificationModel->getByUserId($userId, 5)
        ];
        
        $this->view('student/dashboard', $data);
    }
    
    public function topics() {
        $this->checkStudentSession();
        $topicModel = $this->model('Topic');
        
        $data = [
            'title' => 'Danh sách đề tài',
            'topics' => $topicModel->getAllWithTeacher()
        ];
        
        $this->view('student/topics', $data);
    }
    
    public function register($topicId) {
        $userId = $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $registrationModel = $this->model('Registration');
            $result = $registrationModel->register($userId, $topicId);
            
            if ($result) {
                $_SESSION['success'] = 'Đăng ký đề tài thành công!';
            } else {
                $_SESSION['error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
            }
            header('Location: /PHP-BCTH/public/student/topics');
            exit;
        }
    }
    
    public function progress() {
        $userId = $this->checkStudentSession();
        $progressModel = $this->model('ProgressReport');
        $registrationModel = $this->model('Registration');
        
        $registration = $registrationModel->getByStudentId($userId);
        
        $data = [
            'title' => 'Báo cáo tiến độ',
            'registration' => $registration,
            'progress_reports' => $registration ? $progressModel->getByRegistrationId($registration['registration_id']) : []
        ];
        
        $this->view('student/progress', $data);
    }
    
    public function addProgress() {
        $userId = $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $progressModel = $this->model('ProgressReport');
            $result = $progressModel->create($_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm báo cáo tiến độ thành công!';
            } else {
                $_SESSION['error'] = 'Thêm báo cáo thất bại.';
            }
            header('Location: /PHP-BCTH/public/student/progress');
            exit;
        }
    }
    
    public function notifications() {
        $userId = $this->checkStudentSession();
        $notificationModel = $this->model('Notification');
        
        $data = [
            'title' => 'Thông báo',
            'notifications' => $notificationModel->getByUserId($userId)
        ];
        
        $this->view('student/notifications', $data);
    }
    
    public function submission() {
        $userId = $this->checkStudentSession();
        $submissionModel = $this->model('Submission');
        $registrationModel = $this->model('Registration');
        
        $registration = $registrationModel->getByStudentId($userId);
        
        $data = [
            'title' => 'Nộp bài đồ án',
            'registration' => $registration,
            'submission' => $registration ? $submissionModel->getByRegistrationId($registration['registration_id']) : null
        ];
        
        $this->view('student/submission', $data);
    }
    
    public function submitProject() {
        $userId = $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submissionModel = $this->model('Submission');
            $result = $submissionModel->createOrUpdate($_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Nộp bài thành công!';
            } else {
                $_SESSION['error'] = 'Nộp bài thất bại.';
            }
            header('Location: /PHP-BCTH/public/student/submission');
            exit;
        }
    }
    
    public function profile() {
        $userId = $this->checkStudentSession();
        $userModel = $this->model('User');
        
        $data = [
            'title' => 'Thông tin cá nhân',
            'user' => $userModel->getById($userId)
        ];
        
        $this->view('student/profile', $data);
    }
    
    public function updateProfile() {
        $userId = $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');
            $result = $userModel->update($userId, $_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật thông tin thành công!';
                $_SESSION['full_name'] = $_POST['full_name'];
            } else {
                $_SESSION['error'] = 'Cập nhật thất bại.';
            }
            header('Location: /PHP-BCTH/public/student/profile');
            exit;
        }
    }
    
    public function uploadAvatar() {
        $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            
            // Kiểm tra lỗi upload
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = 'Lỗi upload file!';
                header('Location: /PHP-BCTH/public/student/profile');
                exit;
            }
            
            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                $_SESSION['error'] = 'Chỉ chấp nhận file ảnh (JPG, PNG, GIF, WEBP)!';
                header('Location: /PHP-BCTH/public/student/profile');
                exit;
            }
            
            // Kiểm tra kích thước (max 2MB)
            if ($file['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = 'File quá lớn! Tối đa 2MB.';
                header('Location: /PHP-BCTH/public/student/profile');
                exit;
            }
            
            // Tạo thư mục nếu chưa có
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/PHP-BCTH/public/images/avatars/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Tên file = username.jpg
            $username = $_SESSION['username'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $newFileName = $username . '.jpg';
            $targetPath = $uploadDir . $newFileName;
            
            // Xóa file cũ nếu có
            if (file_exists($targetPath)) {
                unlink($targetPath);
            }
            
            // Di chuyển file
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                $_SESSION['success'] = 'Cập nhật ảnh đại diện thành công!';
            } else {
                $_SESSION['error'] = 'Không thể lưu file!';
            }
        }
        
        header('Location: /PHP-BCTH/public/student/profile');
        exit;
    }
    
    public function changePassword() {
        $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
                header('Location: /PHP-BCTH/public/student/changePassword');
                exit;
            }
            
            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
                header('Location: /PHP-BCTH/public/student/changePassword');
                exit;
            }
            
            if (strlen($newPassword) < 6) {
                $_SESSION['error'] = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
                header('Location: /PHP-BCTH/public/student/changePassword');
                exit;
            }
            
            // Kiểm tra mật khẩu hiện tại
            $userModel = $this->model('User');
            $user = $userModel->findById($_SESSION['user_id']);
            
            $passwordMatch = false;
            if ($currentPassword === $user['password']) {
                $passwordMatch = true;
            } elseif (password_verify($currentPassword, $user['password'])) {
                $passwordMatch = true;
            }
            
            if (!$passwordMatch) {
                $_SESSION['error'] = 'Mật khẩu hiện tại không đúng!';
                header('Location: /PHP-BCTH/public/student/changePassword');
                exit;
            }
            
            // Cập nhật mật khẩu mới
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = Database::getInstance()->prepare("UPDATE users SET password = ? WHERE user_id = ?");
            $result = $stmt->execute([$hashedPassword, $_SESSION['user_id']]);
            
            if ($result) {
                $_SESSION['success'] = 'Đổi mật khẩu thành công!';
                header('Location: /PHP-BCTH/public/student/profile');
            } else {
                $_SESSION['error'] = 'Đổi mật khẩu thất bại!';
                header('Location: /PHP-BCTH/public/student/changePassword');
            }
            exit;
        }
        
        $this->view('student/change_password', ['title' => 'Đổi mật khẩu']);
    }
    
    // ==================== NEW FEATURES ====================
    
    /**
     * Calendar & Deadlines page
     */
    public function calendar() {
        $userId = $this->checkStudentSession();
        $registrationModel = $this->model('Registration');
        
        $data = [
            'title' => 'Lịch & Deadline',
            'registration' => $registrationModel->getByStudentId($userId)
        ];
        
        $this->view('student/calendar', $data);
    }
    
    /**
     * Documents & Templates page
     */
    public function documents() {
        $this->checkStudentSession();
        
        $data = [
            'title' => 'Tài liệu mẫu'
        ];
        
        $this->view('student/documents', $data);
    }
    
    /**
     * Contact Teacher page
     */
    public function contact() {
        $userId = $this->checkStudentSession();
        $registrationModel = $this->model('Registration');
        
        $data = [
            'title' => 'Liên hệ GVHD',
            'registration' => $registrationModel->getByStudentId($userId)
        ];
        
        $this->view('student/contact', $data);
    }
    
    /**
     * Send message to teacher
     */
    public function sendMessage() {
        $userId = $this->checkStudentSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notificationModel = $this->model('Notification');
            $registrationModel = $this->model('Registration');
            
            $registration = $registrationModel->getByStudentId($userId);
            if (!$registration) {
                $_SESSION['error'] = 'Bạn chưa đăng ký đề tài!';
                header('Location: /PHP-BCTH/public/student/contact');
                exit;
            }
            
            // Get teacher_id from topic
            $topicModel = $this->model('Topic');
            $topic = $topicModel->getById($registration['topic_id']);
            
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $subject = $_POST['subject'] ?? '';
            
            $fullTitle = "[{$subject}] {$title}";
            $fullContent = "Từ: " . ($_SESSION['full_name'] ?? 'Sinh viên') . "\n\n" . $content;
            
            $result = $notificationModel->create($userId, $topic['teacher_id'], $fullTitle, $fullContent);
            
            if ($result) {
                $_SESSION['success'] = 'Gửi tin nhắn thành công! GVHD sẽ phản hồi sớm.';
            } else {
                $_SESSION['error'] = 'Gửi tin nhắn thất bại!';
            }
            
            header('Location: /PHP-BCTH/public/student/contact');
            exit;
        }
    }
    
    /**
     * Toggle favorite topic (AJAX)
     */
    public function toggleFavorite($topicId = null) {
        $this->checkStudentSession();
        
        if (!isset($_SESSION['favorite_topics'])) {
            $_SESSION['favorite_topics'] = [];
        }
        
        $topicId = intval($topicId);
        
        if (in_array($topicId, $_SESSION['favorite_topics'])) {
            $_SESSION['favorite_topics'] = array_diff($_SESSION['favorite_topics'], [$topicId]);
            $status = 'removed';
        } else {
            $_SESSION['favorite_topics'][] = $topicId;
            $status = 'added';
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['status' => $status, 'favorites' => $_SESSION['favorite_topics']]);
            exit;
        }
        
        header('Location: /PHP-BCTH/public/student/topics');
        exit;
    }
}
