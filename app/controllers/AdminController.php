<?php
class AdminController extends Controller {
    
    public function __construct() {
        // Debug: Log mọi request đến AdminController
        $logFile = __DIR__ . '/../../debug.log';
        file_put_contents($logFile, date('Y-m-d H:i:s') . " AdminController called - Method: " . $_SERVER['REQUEST_METHOD'] . " - URI: " . $_SERVER['REQUEST_URI'] . "\n", FILE_APPEND);
    }
    
    public function test() {
        echo "<h1>TEST ENDPOINT WORKS!</h1>";
        echo "<p>AdminController::test() được gọi thành công</p>";
        exit;
    }
    
    private function checkAdminSession() {
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
        
        // Kiểm tra role - redirect về trang phù hợp nếu không phải admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $role = $_SESSION['role'] ?? '';
            
            // Redirect về trang phù hợp với role hiện tại
            switch ($role) {
                case 'student':
                    header('Location: ' . $basePath . '/student');
                    break;
                case 'teacher':
                    header('Location: ' . $basePath . '/teacher');
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
        $this->checkAdminSession();
        $userModel = $this->model('User');
        $topicModel = $this->model('Topic');
        
        $data = [
            'title' => 'Trang quản trị',
            'total_students' => $userModel->countByRole('student'),
            'total_teachers' => $userModel->countByRole('teacher'),
            'total_topics' => $topicModel->countAll(),
            'topic_stats' => $topicModel->getStatistics()
        ];
        
        $this->view('admin/dashboard', $data);
    }
    
    public function users() {
        $this->checkAdminSession();
        $userModel = $this->model('User');
        
        // Lấy tham số tìm kiếm
        $role = $_GET['role'] ?? 'all';
        $search = $_GET['search'] ?? '';
        
        // Lấy danh sách người dùng theo bộ lọc
        if ($role !== 'all') {
            $users = $userModel->searchByRole($role, $search);
        } else {
            $users = $userModel->search($search);
        }
        
        $data = [
            'title' => 'Quản lý người dùng',
            'users' => $users,
            'current_role' => $role,
            'current_search' => $search,
            'total_students' => $userModel->countByRole('student'),
            'total_teachers' => $userModel->countByRole('teacher'),
            'total_admins' => $userModel->countByRole('admin')
        ];
        $this->view('admin/users', $data);
    }
    
    public function createUser() {
        $this->checkAdminSession();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // DEBUG: Log để biết có vào đây không
            $logFile = __DIR__ . '/../../debug.log';
            file_put_contents($logFile, date('Y-m-d H:i:s') . " === AdminController::createUser POST ===\n", FILE_APPEND);
            file_put_contents($logFile, date('Y-m-d H:i:s') . " POST data: " . print_r($_POST, true) . "\n", FILE_APPEND);
            
            $userModel = $this->model('User');
            
            // Đơn giản hóa - chỉ tạo user, không validate phức tạp
            try {
                $result = $userModel->create($_POST);
                file_put_contents($logFile, date('Y-m-d H:i:s') . " Create result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n", FILE_APPEND);
                
                if ($result) {
                    $_SESSION['success'] = 'Thêm người dùng thành công!';
                } else {
                    $_SESSION['error'] = isset($_SESSION['error']) ? $_SESSION['error'] : 'Có lỗi xảy ra khi thêm người dùng!';
                }
            } catch (Exception $e) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " Exception: " . $e->getMessage() . "\n", FILE_APPEND);
                $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
            }
            
            header('Location: /PHP-BCTH/public/admin/users');
            exit;
        }
        
        $data = [
            'title' => 'Thêm người dùng mới',
            'action' => 'create'
        ];
        $this->view('admin/user_form', $data);
    }
    
    public function editUser($id) {
        $this->checkAdminSession();
        $userModel = $this->model('User');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $userModel->update($id, $_POST);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật người dùng thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật!';
            }
            
            header('Location: /PHP-BCTH/public/admin/users');
            exit;
        }
        
        $data = [
            'title' => 'Chỉnh sửa người dùng',
            'user' => $userModel->getById($id),
            'action' => 'edit'
        ];
        $this->view('admin/user_form', $data);
    }
    
    public function deleteUser($id) {
        $this->checkAdminSession();
        $userModel = $this->model('User');
        
        $result = $userModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Xóa người dùng thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa người dùng!';
        }
        
        header('Location: /PHP-BCTH/public/admin/users');
        exit;
    }
    
    public function timeSettings() {
        $timeModel = $this->model('TimeSetting');
        $data = [
            'title' => 'Cài đặt thời gian',
            'settings' => $timeModel->getAll()
        ];
        $this->view('admin/time_settings', $data);
    }
    
    public function topics() {
        $topicModel = $this->model('Topic');
        $data = [
            'title' => 'Quản lý đề tài',
            'topics' => $topicModel->getAll()
        ];
        $this->view('admin/topics', $data);
    }
}
