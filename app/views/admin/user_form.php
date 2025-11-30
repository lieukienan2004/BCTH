<?php
$adminInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'A', 0, 1, 'UTF-8'), 'UTF-8');
$isEdit = ($data['action'] ?? 'create') === 'edit';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Sửa người dùng' : 'Thêm người dùng' ?> | TVU Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { 'inter': ['Inter', 'sans-serif'] } } } }</script>
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-100 via-amber-50/30 to-orange-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xl"><?= $isEdit ? '✏️' : '➕' ?></span>
                    <h2 class="text-xl font-bold"><?= $isEdit ? 'Chỉnh sửa người dùng' : 'Thêm người dùng mới' ?></h2>
                </div>
                <p class="text-white/80 text-sm"><?= $isEdit ? 'Cập nhật thông tin tài khoản' : 'Tạo tài khoản mới cho hệ thống' ?></p>
            </div>
            <a href="/PHP-BCTH/public/admin/users" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-xl transition-all flex items-center gap-2">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </header>

    <div class="p-6 lg:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-person-fill text-blue-500"></i>
                            Thông tin người dùng
                        </h3>
                    </div>
                    <form method="POST" action="<?= $isEdit ? '/PHP-BCTH/public/admin/editUser/' . $data['user']['user_id'] : '/PHP-BCTH/public/admin/createUser' ?>" class="p-6 space-y-5">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tên đăng nhập <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="username" 
                                    value="<?= htmlspecialchars($data['user']['username'] ?? '') ?>"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all <?= $isEdit ? 'bg-gray-100 cursor-not-allowed' : '' ?>" 
                                    placeholder="Nhập tên đăng nhập"
                                    <?= $isEdit ? 'readonly' : 'required' ?>>
                                <?php if ($isEdit): ?>
                                <p class="text-xs text-gray-500 mt-1">Không thể thay đổi tên đăng nhập</p>
                                <?php endif; ?>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <?= $isEdit ? 'Mật khẩu mới' : 'Mật khẩu' ?> <?= !$isEdit ? '<span class="text-red-500">*</span>' : '' ?>
                                </label>
                                <input type="password" name="password" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" 
                                    placeholder="<?= $isEdit ? 'Để trống nếu không đổi' : 'Nhập mật khẩu' ?>"
                                    <?= !$isEdit ? 'required' : '' ?>>
                                <?php if ($isEdit): ?>
                                <p class="text-xs text-gray-500 mt-1">Chỉ nhập nếu muốn đổi mật khẩu</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Họ và tên <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" 
                                value="<?= htmlspecialchars($data['user']['full_name'] ?? '') ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" 
                                placeholder="Nhập họ và tên đầy đủ" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" 
                                value="<?= htmlspecialchars($data['user']['email'] ?? '') ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" 
                                placeholder="example@tvu.edu.vn" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Vai trò <span class="text-red-500">*</span>
                                </label>
                                <select name="role" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" required>
                                    <option value="">-- Chọn vai trò --</option>
                                    <option value="admin" <?= isset($data['user']) && $data['user']['role'] === 'admin' ? 'selected' : '' ?>>🛡️ Quản trị viên</option>
                                    <option value="teacher" <?= isset($data['user']) && $data['user']['role'] === 'teacher' ? 'selected' : '' ?>>👨‍🏫 Giảng viên</option>
                                    <option value="student" <?= isset($data['user']) && $data['user']['role'] === 'student' ? 'selected' : '' ?>>🎓 Sinh viên</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mã số (SV/GV)
                                </label>
                                <input type="text" name="student_code" 
                                    value="<?= htmlspecialchars($data['user']['student_code'] ?? '') ?>"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" 
                                    placeholder="VD: 110122094">
                                <p class="text-xs text-gray-500 mt-1">Bắt buộc với Sinh viên và Giảng viên</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Số điện thoại
                            </label>
                            <input type="tel" name="phone" 
                                value="<?= htmlspecialchars($data['user']['phone'] ?? '') ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" 
                                placeholder="0123456789">
                        </div>
                        
                        <div class="flex gap-3 pt-4 border-t border-gray-100">
                            <a href="/PHP-BCTH/public/admin/users" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl text-center transition-all">
                                <i class="bi bi-x-lg mr-2"></i>Hủy
                            </a>
                            <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                                <i class="bi bi-check-lg mr-2"></i><?= $isEdit ? 'Cập nhật' : 'Thêm người dùng' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar Info -->
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-cyan-50 to-blue-50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-info-circle text-cyan-500"></i>
                            Hướng dẫn
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Vai trò:</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li class="flex items-start gap-2">
                                    <span class="w-6 h-6 bg-red-100 text-red-600 rounded-lg flex items-center justify-center flex-shrink-0">🛡️</span>
                                    <span><strong>Admin:</strong> Quản lý toàn bộ hệ thống</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-6 h-6 bg-green-100 text-green-600 rounded-lg flex items-center justify-center flex-shrink-0">👨‍🏫</span>
                                    <span><strong>Giảng viên:</strong> Quản lý đề tài và sinh viên</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <span class="w-6 h-6 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">🎓</span>
                                    <span><strong>Sinh viên:</strong> Đăng ký và thực hiện đồ án</span>
                                </li>
                            </ul>
                        </div>
                        <hr class="border-gray-100">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Lưu ý:</h4>
                            <ul class="space-y-1 text-sm text-gray-600">
                                <li class="flex items-center gap-2">
                                    <i class="bi bi-check-circle text-green-500"></i>
                                    Tên đăng nhập không thể thay đổi
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="bi bi-check-circle text-green-500"></i>
                                    Mật khẩu được mã hóa an toàn
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="bi bi-check-circle text-green-500"></i>
                                    Email phải là duy nhất
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <?php if ($isEdit && isset($data['user'])): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-50 to-orange-50">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-clock-history text-amber-500"></i>
                            Thông tin tài khoản
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Ngày tạo:</span>
                            <span class="font-medium text-gray-800"><?= date('d/m/Y H:i', strtotime($data['user']['created_at'])) ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Cập nhật:</span>
                            <span class="font-medium text-gray-800"><?= date('d/m/Y H:i', strtotime($data['user']['updated_at'])) ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

</body>
</html>
