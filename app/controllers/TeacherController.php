<?php
class TeacherController extends Controller {
    
    private function checkTeacherSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Kiểm tra session hết hạn hoặc chưa đăng nhập
        if (!isset($_SESSION['user_id'])) {
            // Xóa toàn bộ session cũ
            session_unset();
            session_destroy();
            
            // Bắt đầu session mới để lưu thông báo lỗi
            session_start();
            $_SESSION['error'] = 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.';
            header('Location: /PHP-BCTH/public/auth/login');
            exit;
        }
        
        // Kiểm tra role - redirect về trang phù hợp nếu không phải teacher
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'teacher') {
            $role = $_SESSION['role'] ?? '';
            
            // Redirect về trang phù hợp với role hiện tại
            switch ($role) {
                case 'student':
                    header('Location: /PHP-BCTH/public/student');
                    break;
                case 'admin':
                    header('Location: /PHP-BCTH/public/admin');
                    break;
                default:
                    header('Location: /PHP-BCTH/public/auth/login');
            }
            exit;
        }
        
        // Refresh session để kéo dài thời gian
        $_SESSION['last_activity'] = time();
        
        return $_SESSION['user_id'];
    }
    
    public function index() {
        try {
            $teacherId = $this->checkTeacherSession();
            
            $topicModel = $this->model('Topic');
            $registrationModel = $this->model('Registration');
            
            $topics = $topicModel->getByTeacherId($teacherId);
            $registrations = $registrationModel->getByTeacherId($teacherId);
            
            $data = [
                'title' => 'Trang giảng viên',
                'teacher_id' => $teacherId,
                'topics' => $topics,
                'registrations' => $registrations,
                'total_topics' => count($topics),
                'total_students' => count($registrations)
            ];
            
            $this->view('teacher/dashboard', $data);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            echo "<br>File: " . $e->getFile();
            echo "<br>Line: " . $e->getLine();
            die();
        }
    }
    
    public function topics() {
        $teacherId = $this->checkTeacherSession();
        
        $topicModel = $this->model('Topic');
        $data = [
            'title' => 'Quản lý đề tài',
            'topics' => $topicModel->getByTeacherId($teacherId)
        ];
        
        $this->view('teacher/topics', $data);
    }
    
    public function createTopic() {
        $teacherId = $this->checkTeacherSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $topicModel = $this->model('Topic');
            $_POST['teacher_id'] = $teacherId;
            $result = $topicModel->create($_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Tạo đề tài thành công! Đề tài đang chờ admin duyệt.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi tạo đề tài!';
            }
            
            header('Location: /PHP-BCTH/public/teacher/topics');
            exit;
        }
        
        $this->view('teacher/topic_form', ['title' => 'Tạo đề tài mới', 'action' => 'create']);
    }
    
    public function editTopic($topicId) {
        $teacherId = $this->checkTeacherSession();
        
        $topicModel = $this->model('Topic');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $topicModel->update($topicId, $_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật đề tài thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật đề tài!';
            }
            
            header('Location: /PHP-BCTH/public/teacher/topics');
            exit;
        }
        
        $data = [
            'title' => 'Chỉnh sửa đề tài',
            'topic' => $topicModel->getById($topicId),
            'action' => 'edit'
        ];
        
        $this->view('teacher/topic_form', $data);
    }
    
    public function deleteTopic($topicId) {
        $this->checkTeacherSession();
        
        $topicModel = $this->model('Topic');
        $result = $topicModel->delete($topicId);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa đề tài thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa đề tài!';
        }
        
        header('Location: /PHP-BCTH/public/teacher/topics');
        exit;
    }
    
    public function students() {
        $teacherId = $this->checkTeacherSession();
        
        $registrationModel = $this->model('Registration');
        $data = [
            'title' => 'Sinh viên hướng dẫn',
            'registrations' => $registrationModel->getByTeacherId($teacherId)
        ];
        
        $this->view('teacher/students', $data);
    }
    
    public function sendNotification() {
        $teacherId = $this->checkTeacherSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notificationModel = $this->model('Notification');
            $registrationModel = $this->model('Registration');
            
            $recipientType = $_POST['recipient_type'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            
            if ($recipientType === 'all') {
                // Gửi đến tất cả sinh viên của giáo viên
                $students = $registrationModel->getByTeacherId($teacherId);
                $count = 0;
                
                foreach ($students as $student) {
                    if ($student['status'] === 'approved') {
                        $notificationModel->create($teacherId, $student['student_id'], $title, $content);
                        $count++;
                    }
                }
                
                $_SESSION['success'] = "Đã gửi thông báo đến $count sinh viên!";
            } else {
                // Gửi đến sinh viên cụ thể
                $studentId = $_POST['student_id'];
                $notificationModel->create($teacherId, $studentId, $title, $content);
                $_SESSION['success'] = 'Đã gửi thông báo thành công!';
            }
            
            header('Location: /PHP-BCTH/public/teacher/sendNotificationForm');
            exit;
        }
        
        // Hiển thị form
        $registrationModel = $this->model('Registration');
        $students = $registrationModel->getByTeacherId($teacherId);
        
        // Chỉ lấy sinh viên đã được duyệt
        $approvedStudents = array_filter($students, function($s) {
            return $s['status'] === 'approved';
        });
        
        $data = [
            'title' => 'Gửi thông báo',
            'students' => $approvedStudents
        ];
        
        $this->view('teacher/send_notification', $data);
    }
    
    public function sendNotificationForm() {
        $this->sendNotification();
    }
    
    public function progress($registrationId = null) {
        $teacherId = $this->checkTeacherSession();
        
        $registrationModel = $this->model('Registration');
        $progressModel = $this->model('ProgressReport');
        $submissionModel = $this->model('Submission');
        
        // Nếu không có registrationId, hiển thị danh sách tất cả sinh viên
        if ($registrationId === null) {
            $data = [
                'title' => 'Tiến độ sinh viên',
                'registrations' => $registrationModel->getByTeacherId($teacherId)
            ];
            $this->view('teacher/progress_list', $data);
            return;
        }
        
        $data = [
            'title' => 'Theo dõi tiến độ',
            'registration' => $registrationModel->getByRegistrationId($registrationId),
            'reports' => $progressModel->getByRegistrationId($registrationId),
            'submission' => $submissionModel->getByRegistrationId($registrationId)
        ];
        
        $this->view('teacher/progress', $data);
    }
    
    public function registrations() {
        $teacherId = $this->checkTeacherSession();
        
        $registrationModel = $this->model('Registration');
        $data = [
            'title' => 'Quản lý đăng ký',
            'registrations' => $registrationModel->getByTeacherId($teacherId)
        ];
        
        $this->view('teacher/registrations', $data);
    }
    
    public function approveRegistration($registrationId) {
        $teacherId = $this->checkTeacherSession();
        
        $registrationModel = $this->model('Registration');
        $notificationModel = $this->model('Notification');
        
        // Cập nhật trạng thái
        $result = $registrationModel->updateStatus($registrationId, 'approved');
        
        if ($result) {
            // Lấy thông tin đăng ký
            $registration = $registrationModel->getByRegistrationId($registrationId);
            
            // Gửi thông báo cho sinh viên
            $notificationModel->create(
                $teacherId,
                $registration['student_id'],
                'Đăng ký đề tài được chấp nhận',
                "Đề tài '{$registration['topic_title']}' của bạn đã được giảng viên chấp nhận. Hãy bắt đầu thực hiện đồ án và cập nhật tiến độ định kỳ."
            );
            
            $_SESSION['success'] = 'Đã chấp nhận sinh viên ' . $registration['student_name'];
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi chấp nhận đăng ký';
        }
        
        header('Location: /PHP-BCTH/public/teacher/registrations');
        exit;
    }
    
    public function rejectRegistration($registrationId) {
        $teacherId = $this->checkTeacherSession();
        
        $registrationModel = $this->model('Registration');
        $notificationModel = $this->model('Notification');
        $topicModel = $this->model('Topic');
        
        // Lấy thông tin đăng ký trước khi từ chối
        $registration = $registrationModel->getByRegistrationId($registrationId);
        
        // Giảm số lượng sinh viên đã đăng ký
        $topicModel->decreaseStudentCount($registration['topic_id']);
        
        // Gửi thông báo cho sinh viên
        $notificationModel->create(
            $teacherId,
            $registration['student_id'],
            'Đăng ký đề tài bị từ chối',
            "Rất tiếc, đề tài '{$registration['topic_title']}' của bạn đã bị từ chối. Bạn có thể đăng ký đề tài khác hoặc liên hệ giảng viên để biết thêm chi tiết."
        );
        
        // Xóa đăng ký (cho phép sinh viên đăng ký lại)
        $result = $registrationModel->deleteRegistration($registrationId);
        
        if ($result) {
            $_SESSION['success'] = 'Đã từ chối sinh viên ' . $registration['student_name'];
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi từ chối đăng ký';
        }
        
        header('Location: /PHP-BCTH/public/teacher/registrations');
        exit;
    }
    
    /**
     * Xem tin nhắn từ sinh viên
     */
    public function messages() {
        $teacherId = $this->checkTeacherSession();
        $notificationModel = $this->model('Notification');
        
        $data = [
            'title' => 'Tin nhắn từ sinh viên',
            'messages' => $notificationModel->getByUserId($teacherId)
        ];
        
        $this->view('teacher/messages', $data);
    }
    
    /**
     * Đánh dấu tin nhắn đã đọc
     */
    public function markMessageRead($messageId) {
        $this->checkTeacherSession();
        $notificationModel = $this->model('Notification');
        
        $notificationModel->markAsRead($messageId);
        
        header('Location: /PHP-BCTH/public/teacher/messages');
        exit;
    }
    
    /**
     * Xóa tin nhắn
     */
    public function deleteMessage($messageId) {
        $this->checkTeacherSession();
        $notificationModel = $this->model('Notification');
        
        $result = $notificationModel->delete($messageId);
        
        if ($result) {
            $_SESSION['success'] = 'Đã xóa tin nhắn!';
        } else {
            $_SESSION['error'] = 'Không thể xóa tin nhắn!';
        }
        
        header('Location: /PHP-BCTH/public/teacher/messages');
        exit;
    }
    
    /**
     * Phản hồi tin nhắn sinh viên
     */
    public function replyMessage() {
        $teacherId = $this->checkTeacherSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $notificationModel = $this->model('Notification');
            
            $studentId = $_POST['student_id'] ?? '';
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if ($studentId && $title && $content) {
                $result = $notificationModel->create($teacherId, $studentId, $title, $content);
                
                if ($result) {
                    $_SESSION['success'] = 'Đã gửi phản hồi thành công!';
                } else {
                    $_SESSION['error'] = 'Gửi phản hồi thất bại!';
                }
            } else {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin!';
            }
        }
        
        header('Location: /PHP-BCTH/public/teacher/messages');
        exit;
    }
}