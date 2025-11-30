<?php
$currentPage = $_GET['url'] ?? 'admin';
$currentPage = explode('/', $currentPage);
$activePage = $currentPage[1] ?? 'index';
?>

<!-- Nút Toggle Sidebar -->
<button onclick="toggleAdminSidebar()" id="adminHamburgerBtn" class="fixed top-4 left-4 z-50 p-3 bg-slate-800 text-white rounded-xl shadow-lg hover:bg-slate-700 transition-all hidden">
    <i class="bi bi-list text-2xl"></i>
</button>

<!-- Sidebar -->
<aside id="adminSidebar" class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-indigo-900 text-white shadow-2xl z-40 flex flex-col transition-transform duration-300">
    <!-- Logo & Brand -->
    <div class="p-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <button onclick="toggleAdminSidebar()" class="p-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all">
                <i class="bi bi-list text-xl"></i>
            </button>
            <div class="w-11 h-11 bg-white rounded-xl p-1.5 shadow-lg">
                <img src="/PHP-BCTH/public/images/logoTVU.png" alt="TVU" class="w-full h-full object-contain">
            </div>
            <div class="flex-1">
                <h1 class="font-bold text-base bg-gradient-to-r from-amber-300 to-orange-400 bg-clip-text text-transparent">TVU Admin</h1>
                <p class="text-xs text-slate-400">Quản trị hệ thống</p>
            </div>
        </div>
    </div>
    
    <!-- Admin Info -->
    <div class="p-4 mx-4 mt-4 bg-gradient-to-r from-amber-600/20 to-orange-600/20 rounded-2xl border border-white/10 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <?php 
            $adminInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'A', 0, 1, 'UTF-8'), 'UTF-8');
            ?>
            <div class="w-14 h-14 rounded-2xl overflow-hidden border-2 border-amber-400/50 shadow-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center">
                <span class="text-white text-xl font-bold"><?= $adminInitial ?></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm truncate"><?= $_SESSION['full_name'] ?? 'Administrator' ?></p>
                <p class="text-xs text-slate-400"><?= $_SESSION['username'] ?? 'admin' ?></p>
                <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-amber-500/30 text-amber-300 text-xs rounded-full">
                    <i class="bi bi-shield-check"></i> Quản trị viên
                </span>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="text-xs text-slate-500 uppercase tracking-wider mb-3 px-3 font-semibold">📊 Tổng quan</p>
        
        <a href="/PHP-BCTH/public/admin" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'index' ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-speedometer2 text-lg"></i>
            <span>Dashboard</span>
        </a>

        <p class="text-xs text-slate-500 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">👥 Quản lý</p>
        
        <a href="/PHP-BCTH/public/admin/users" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'users' || $activePage == 'createUser' || $activePage == 'editUser' ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-people-fill text-lg"></i>
            <span>Người dùng</span>
        </a>
        
        <a href="/PHP-BCTH/public/admin/topics" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'topics' ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-journal-bookmark-fill text-lg"></i>
            <span>Đề tài</span>
            <?php if (isset($data['pending_topics']) && $data['pending_topics'] > 0): ?>
                <span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-xs rounded-full animate-pulse"><?= $data['pending_topics'] ?></span>
            <?php endif; ?>
        </a>

        <p class="text-xs text-slate-500 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">⚙️ Cài đặt</p>
        
        <a href="/PHP-BCTH/public/admin/timeSettings" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'timeSettings' ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg shadow-amber-500/30' : 'text-slate-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-clock-history text-lg"></i>
            <span>Thời gian đăng ký</span>
        </a>
    </nav>
    
    <!-- Logout Button -->
    <div class="p-4 border-t border-white/10">
        <a href="/PHP-BCTH/public/logout" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all">
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
let adminSidebarOpen = true;

function toggleAdminSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const hamburgerBtn = document.getElementById('adminHamburgerBtn');
    const mainContent = document.querySelector('main');
    
    adminSidebarOpen = !adminSidebarOpen;
    
    if (adminSidebarOpen) {
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
