<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg';
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">👤</span><h2 class="text-xl font-bold">Thông tin cá nhân</h2></div>
                <p class="text-white/80 text-sm">Quản lý thông tin tài khoản của bạn</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></button>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-cyan-400 to-indigo-500 flex items-center justify-center">
                            <img src="<?= $avatarPath ?>" alt="Avatar" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="text-white text-lg font-bold hidden"><?= $userInitial ?></span>
                        </div>
                        <i class="bi bi-caret-down-fill text-white/80 text-xs transition-transform" id="dropdownArrow"></i>
                    </button>
                    <?php include_once __DIR__ . '/../layouts/user_dropdown.php'; ?>
                </div>
            </div>
        </div>
    </header>
    
    <div class="p-8">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
            <p class="text-red-700"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Avatar Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 h-24 relative">
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                            <div class="relative">
                                <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-white shadow-xl">
                                    <img id="avatarPreview" src="<?= $avatarPath ?>" alt="Avatar" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['full_name'] ?? 'User') ?>&background=3b82f6&color=fff&size=128'">
                                </div>
                                <label for="avatarInput" class="absolute bottom-0 right-0 w-8 h-8 bg-blue-500 hover:bg-blue-600 rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all">
                                    <i class="bi bi-camera text-white text-sm"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-16 pb-6 px-6 text-center">
                        <h3 class="font-bold text-gray-800 text-xl"><?= $data['user']['full_name'] ?? 'Sinh viên' ?></h3>
                        <p class="text-gray-500 text-sm"><?= $data['user']['email'] ?? '' ?></p>
                        <div class="mt-4 flex justify-center gap-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">Sinh viên</span>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">Active</span>
                        </div>
                    </div>
                    
                    <!-- Avatar Upload Form (Hidden) -->
                    <form method="POST" action="/PHP-BCTH/public/student/uploadAvatar" enctype="multipart/form-data" id="avatarForm">
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAndSubmitAvatar(this)">
                    </form>
                </div>
                
                <!-- Quick Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle text-blue-500"></i>
                        Thông tin nhanh
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-gray-500 text-sm">Mã SV</span>
                            <span class="font-semibold text-gray-800"><?= $data['user']['student_code'] ?? 'N/A' ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-gray-500 text-sm">Tài khoản</span>
                            <span class="font-semibold text-gray-800"><?= $data['user']['username'] ?? '' ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <span class="text-gray-500 text-sm">Ngày tạo</span>
                            <span class="font-semibold text-gray-800"><?= isset($data['user']['created_at']) ? date('d/m/Y', strtotime($data['user']['created_at'])) : 'N/A' ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- Security Card -->
                <div class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 text-white">
                    <h3 class="font-bold mb-3 flex items-center gap-2">
                        <i class="bi bi-shield-lock"></i>
                        Bảo mật
                    </h3>
                    <p class="text-white/80 text-sm mb-4">Đổi mật khẩu định kỳ để bảo vệ tài khoản.</p>
                    <a href="/PHP-BCTH/public/student/changePassword" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl transition-all text-sm">
                        <i class="bi bi-key"></i>
                        Đổi mật khẩu
                    </a>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-cyan-500 to-blue-500">
                        <h2 class="font-bold text-white flex items-center gap-2">
                            <i class="bi bi-pencil-square"></i>
                            Cập nhật thông tin
                        </h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="/PHP-BCTH/public/student/updateProfile" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="bi bi-person-badge text-gray-400 mr-1"></i>Tên đăng nhập
                                    </label>
                                    <input type="text" class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed" value="<?= $data['user']['username'] ?? '' ?>" disabled>
                                    <p class="text-xs text-gray-400 mt-1">Không thể thay đổi</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class="bi bi-credit-card text-gray-400 mr-1"></i>Mã sinh viên
                                    </label>
                                    <input type="text" class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed" value="<?= $data['user']['student_code'] ?? '' ?>" disabled>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-person text-gray-400 mr-1"></i>Họ và tên <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="full_name" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" value="<?= $data['user']['full_name'] ?? '' ?>" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-envelope text-gray-400 mr-1"></i>Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" value="<?= $data['user']['email'] ?? '' ?>" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-telephone text-gray-400 mr-1"></i>Số điện thoại
                                </label>
                                <input type="tel" name="phone" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" value="<?= $data['user']['phone'] ?? '' ?>" placeholder="0123456789">
                            </div>
                            
                            <input type="hidden" name="role" value="<?= $data['user']['role'] ?? 'student' ?>">
                            <input type="hidden" name="student_code" value="<?= $data['user']['student_code'] ?? '' ?>">
                            
                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                                    <i class="bi bi-check-lg"></i>
                                    Lưu thay đổi
                                </button>
                                <button type="reset" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all">
                                    Hủy
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Activity Log -->
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-clock-history text-purple-500"></i>
                            Hoạt động gần đây
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-box-arrow-in-right text-green-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Đăng nhập thành công</p>
                                    <p class="text-xs text-gray-500">Hôm nay, <?= date('H:i') ?></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-person-check text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 text-sm">Cập nhật thông tin cá nhân</p>
                                    <p class="text-xs text-gray-500"><?= isset($data['user']['updated_at']) ? date('d/m/Y H:i', strtotime($data['user']['updated_at'])) : 'Chưa cập nhật' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function previewAndSubmitAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
            // Auto submit after preview
            if (confirm('Bạn có muốn cập nhật ảnh đại diện này?')) {
                document.getElementById('avatarForm').submit();
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<style>
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
