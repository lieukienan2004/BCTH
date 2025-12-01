<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$currentPage = $_GET['url'] ?? 'teacher';
$currentPage = explode('/', $currentPage);
$activePage = $currentPage[1] ?? 'index';
?>

<!-- Nút Toggle Sidebar -->
<button onclick="toggleTeacherSidebar()" id="teacherHamburgerBtn" class="fixed top-4 left-4 z-50 p-3 bg-blue-800 text-white rounded-xl shadow-lg hover:bg-blue-700 transition-all hidden">
    <i class="bi bi-list text-2xl"></i>
</button>

<!-- Sidebar -->
<aside id="teacherSidebar" class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-blue-900 via-blue-800 to-cyan-900 text-white shadow-2xl z-40 flex flex-col transition-transform duration-300">
    <!-- Logo & Brand -->
    <div class="p-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <button onclick="toggleTeacherSidebar()" class="p-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all">
                <i class="bi bi-list text-xl"></i>
            </button>
            <div class="w-11 h-11 bg-white rounded-xl p-1.5 shadow-lg">
                <img src="<?= $basePath ?>/images/logoTVU.png" alt="TVU" class="w-full h-full object-contain">
            </div>
            <div class="flex-1">
                <h1 class="font-bold text-base bg-gradient-to-r from-cyan-300 to-blue-300 bg-clip-text text-transparent">TVU Portal</h1>
                <p class="text-xs text-blue-300/70">Giảng viên</p>
            </div>
        </div>
    </div>
    
    <!-- User Info -->
    <div class="p-4 mx-4 mt-4 bg-gradient-to-r from-blue-600/30 to-cyan-600/30 rounded-2xl border border-white/10 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <?php 
            $teacherInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
            $avatarPath = '$basePath . '/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; 
            ?>
            <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-cyan-400/50 shadow-lg bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                <img src="<?= $avatarPath ?>" alt="Avatar" class="w-full h-full object-cover" 
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <span class="text-white text-xl font-bold hidden items-center justify-center w-full h-full"><?= $teacherInitial ?></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm truncate"><?= $_SESSION['full_name'] ?? 'Giảng viên' ?></p>
                <p class="text-xs text-blue-300/70">Mã GV: <?= $_SESSION['username'] ?? '' ?></p>
                <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-blue-500/30 text-cyan-300 text-xs rounded-full">
                    <i class="bi bi-mortarboard-fill"></i> Khoa CNTT
                </span>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="text-xs text-blue-400/60 uppercase tracking-wider mb-3 px-3 font-semibold">📊 Tổng quan</p>
        
        <a href="<?= $basePath ?>/teacher" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'index' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>

        <p class="text-xs text-blue-400/60 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">📚 Quản lý</p>
        
        <a href="<?= $basePath ?>/teacher/topics" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'topics' || $activePage == 'createTopic' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-journal-bookmark-fill text-lg"></i>
            <span>Quản lý đề tài</span>
        </a>
        
        <a href="<?= $basePath ?>/teacher/registrations" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'registrations' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-clipboard-check-fill text-lg"></i>
            <span>Duyệt đăng ký</span>
            <?php 
            if (isset($data['pending_count']) && $data['pending_count'] > 0): ?>
                <span class="ml-auto px-2 py-0.5 bg-amber-500 text-white text-xs rounded-full animate-pulse"><?= $data['pending_count'] ?></span>
            <?php endif; ?>
        </a>
        
        <a href="<?= $basePath ?>/teacher/students" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'students' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-people-fill text-lg"></i>
            <span>Sinh viên hướng dẫn</span>
        </a>
        
        <a href="<?= $basePath ?>/teacher/progress" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'progress' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-graph-up-arrow text-lg"></i>
            <span>Tiến độ sinh viên</span>
        </a>
        
        <p class="text-xs text-blue-400/60 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">💬 Liên lạc</p>
        
        <a href="<?= $basePath ?>/teacher/messages" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'messages' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-envelope-fill text-lg"></i>
            <span>Tin nhắn từ SV</span>
            <?php if (isset($data['unread_messages']) && $data['unread_messages'] > 0): ?>
                <span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-xs rounded-full animate-pulse"><?= $data['unread_messages'] ?></span>
            <?php endif; ?>
        </a>
        
        <a href="<?= $basePath ?>/teacher/sendNotificationForm" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'sendNotificationForm' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg shadow-blue-500/30' : 'text-blue-100 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-send-fill text-lg"></i>
            <span>Gửi thông báo</span>
        </a>
    </nav>
    
    <!-- Logout Button -->
    <div class="p-4 border-t border-white/10">
        <a href="<?= $basePath ?>/logout" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all">
            <i class="bi bi-box-arrow-right text-lg"></i>
            <span>Đăng xuất</span>
        </a>
    </div>
</aside>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
</style>

<script>
let teacherSidebarOpen = true;

function toggleTeacherSidebar() {
    const sidebar = document.getElementById('teacherSidebar');
    const hamburgerBtn = document.getElementById('teacherHamburgerBtn');
    const mainContent = document.querySelector('main');
    
    teacherSidebarOpen = !teacherSidebarOpen;
    
    if (teacherSidebarOpen) {
        sidebar.classList.remove('-translate-x-full');
        hamburgerBtn.classList.add('hidden');
        if (mainContent) mainContent.classList.add('lg:ml-72');
    } else {
        sidebar.classList.add('-translate-x-full');
        hamburgerBtn.classList.remove('hidden');
        if (mainContent) mainContent.classList.remove('lg:ml-72');
    }
}
</script>
