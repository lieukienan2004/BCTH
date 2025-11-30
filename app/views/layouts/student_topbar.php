<?php
// Common variables for topbar
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$userName = $_SESSION['full_name'] ?? 'Sinh viên';
?>
<div class="flex items-center gap-4">
    <a href="/PHP-BCTH/public/student/notifications" class="relative p-3 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
        <i class="bi bi-bell text-xl"></i>
        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
    </a>
    <div class="relative pl-4 border-l border-white/20">
        <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
            <div class="w-10 h-10 rounded-full bg-white/30 flex items-center justify-center text-white font-bold border-2 border-white shadow-lg">
                <?= $userInitial ?>
            </div>
            <i class="bi bi-caret-down-fill text-white/80 text-xs transition-transform" id="dropdownArrow"></i>
        </button>
        <?php include_once __DIR__ . '/user_dropdown.php'; ?>
    </div>
</div>
