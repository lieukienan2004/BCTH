<?php 
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$userName = $_SESSION['full_name'] ?? 'Sinh viên';
$userAccount = $_SESSION['username'] ?? '';
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
?>
<div id="userDropdown" class="hidden fixed w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="z-index: 99999; top: 70px; right: 24px;">
    <!-- Header -->
    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-4">
        <div class="flex items-center gap-3">
            <div class="w-14 h-14 rounded-full bg-white/20 flex items-center justify-center text-white text-xl font-bold border-2 border-white">
                <?= $userInitial ?>
            </div>
            <div class="text-white">
                <p class="font-bold"><?= htmlspecialchars($userName) ?></p>
                <p class="text-sm text-white/80"><?= htmlspecialchars($userAccount) ?></p>
            </div>
        </div>
    </div>
    <!-- Menu -->
    <div class="p-3 space-y-1">
        <a href="<?= $basePath ?>/student/profile" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all">
            <i class="bi bi-person text-gray-500"></i>
            <span>Thông tin cá nhân</span>
        </a>
        <a href="<?= $basePath ?>/student/changePassword" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-xl transition-all">
            <i class="bi bi-lock text-gray-500"></i>
            <span>Đổi mật khẩu</span>
        </a>
        <div class="border-t border-gray-100 mt-2 pt-2">
            <a href="<?= $basePath ?>/logout" class="flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                <i class="bi bi-box-arrow-right"></i>
                <span>Đăng xuất</span>
            </a>
        </div>
    </div>
</div>
