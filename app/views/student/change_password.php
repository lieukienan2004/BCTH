<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">🔐</span><h2 class="text-xl font-bold">Đổi mật khẩu</h2></div>
                <p class="text-white/80 text-sm">Bảo vệ tài khoản của bạn</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></button>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
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
        <div class="max-w-xl mx-auto">
            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
                <p class="text-red-700"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
                <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Password Form -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                    <h2 class="text-white font-bold flex items-center gap-2">
                        <i class="bi bi-shield-lock-fill"></i>
                        Thay đổi mật khẩu
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" action="/PHP-BCTH/public/student/changePassword" class="space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-key text-gray-400 mr-1"></i>Mật khẩu hiện tại <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" id="currentPassword" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all pr-12" 
                                    placeholder="Nhập mật khẩu hiện tại" required>
                                <button type="button" onclick="togglePassword('currentPassword')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-lock text-gray-400 mr-1"></i>Mật khẩu mới <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="new_password" id="newPassword" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all pr-12" 
                                    placeholder="Nhập mật khẩu mới (ít nhất 6 ký tự)" required minlength="6" onkeyup="checkPasswordStrength(this.value)">
                                <button type="button" onclick="togglePassword('newPassword')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <!-- Password Strength -->
                            <div class="mt-2">
                                <div class="flex gap-1">
                                    <div id="strength1" class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="strength2" class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="strength3" class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                                    <div id="strength4" class="h-1 flex-1 bg-gray-200 rounded-full"></div>
                                </div>
                                <p id="strengthText" class="text-xs text-gray-500 mt-1"></p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="bi bi-lock-fill text-gray-400 mr-1"></i>Xác nhận mật khẩu mới <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="confirm_password" id="confirmPassword" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all pr-12" 
                                    placeholder="Nhập lại mật khẩu mới" required onkeyup="checkPasswordMatch()">
                                <button type="button" onclick="togglePassword('confirmPassword')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <p id="matchText" class="text-xs mt-1"></p>
                        </div>
                        
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg shadow-amber-500/30 transition-all flex items-center justify-center gap-2">
                                <i class="bi bi-check-lg"></i>
                                Đổi mật khẩu
                            </button>
                            <a href="/PHP-BCTH/public/student/profile" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all flex items-center justify-center">
                                Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Security Tips -->
            <div class="mt-6 bg-blue-50 rounded-2xl p-6 border border-blue-200">
                <h3 class="font-bold text-blue-800 flex items-center gap-2 mb-3">
                    <i class="bi bi-lightbulb-fill text-blue-500"></i>
                    Mẹo bảo mật
                </h3>
                <ul class="space-y-2 text-sm text-blue-700">
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-blue-500 mt-0.5"></i>Sử dụng ít nhất 8 ký tự</li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-blue-500 mt-0.5"></i>Kết hợp chữ hoa, chữ thường, số và ký tự đặc biệt</li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-blue-500 mt-0.5"></i>Không sử dụng thông tin cá nhân dễ đoán</li>
                    <li class="flex items-start gap-2"><i class="bi bi-check-circle text-blue-500 mt-0.5"></i>Đổi mật khẩu định kỳ 3-6 tháng</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.nextElementSibling.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}

function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password) && /[a-z]/.test(password)) strength++;
    if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength++;
    
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
    const texts = ['Yếu', 'Trung bình', 'Khá', 'Mạnh'];
    
    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById('strength' + i);
        el.className = 'h-1 flex-1 rounded-full ' + (i <= strength ? colors[strength - 1] : 'bg-gray-200');
    }
    document.getElementById('strengthText').textContent = strength > 0 ? 'Độ mạnh: ' + texts[strength - 1] : '';
}

function checkPasswordMatch() {
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    const matchText = document.getElementById('matchText');
    
    if (confirmPass.length > 0) {
        if (newPass === confirmPass) {
            matchText.textContent = '✓ Mật khẩu khớp';
            matchText.className = 'text-xs mt-1 text-green-600';
        } else {
            matchText.textContent = '✗ Mật khẩu không khớp';
            matchText.className = 'text-xs mt-1 text-red-600';
        }
    } else {
        matchText.textContent = '';
    }
}
</script>
</main>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
