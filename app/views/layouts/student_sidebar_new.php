<?php
$currentPage = $_GET['url'] ?? 'student';
$currentPage = explode('/', $currentPage);
$activePage = $currentPage[1] ?? 'index';
?>

<!-- Nút Toggle Sidebar - hiển thị khi sidebar ẩn -->
<button onclick="toggleSidebar()" id="hamburgerBtn" class="fixed top-4 left-4 z-50 p-3 bg-slate-800 text-white rounded-xl shadow-lg hover:bg-slate-700 transition-all hidden">
    <i class="bi bi-list text-2xl"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 text-white shadow-2xl z-40 flex flex-col transition-transform duration-300">
    <!-- Logo & Brand -->
    <div class="p-6 border-b border-white/10">
        <div class="flex items-center gap-3">
            <!-- Nút Toggle bên trong sidebar -->
            <button onclick="toggleSidebar()" class="p-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all">
                <i class="bi bi-list text-xl" id="hamburgerIcon"></i>
            </button>
            <div class="w-10 h-10 bg-white rounded-xl p-1.5 shadow-lg shadow-blue-500/20">
                <img src="/PHP-BCTH/public/images/logoTVU.png" alt="TVU" class="w-full h-full object-contain">
            </div>
            <div class="flex-1">
                <h1 class="font-bold text-base bg-gradient-to-r from-cyan-400 to-blue-400 bg-clip-text text-transparent">TVU Portal</h1>
                <p class="text-xs text-gray-400">Quản lý Đồ án CNTT</p>
            </div>
        </div>
    </div>
    
    <!-- User Info -->
    <div class="p-4 mx-4 mt-4 bg-gradient-to-r from-blue-600/20 to-purple-600/20 rounded-xl border border-white/10 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <?php 
            $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg';
            $userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'S', 0, 1, 'UTF-8'), 'UTF-8');
            ?>
            <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-cyan-400/50 shadow-lg bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                <img src="<?= $avatarPath ?>" alt="Avatar" class="w-full h-full object-cover" 
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <span class="text-white text-xl font-bold hidden items-center justify-center w-full h-full"><?= $userInitial ?></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-sm truncate"><?= $_SESSION['full_name'] ?? 'Sinh viên' ?></p>
                <p class="text-xs text-gray-400"><?= $_SESSION['username'] ?? '' ?></p>
                <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">
                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>Online
                </span>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="text-xs text-gray-500 uppercase tracking-wider mb-3 px-3 font-semibold">📌 Menu chính</p>
        
        <a href="/PHP-BCTH/public/student" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'index' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-house-door-fill text-lg"></i>
            <span>Trang chủ</span>
        </a>
        
        <a href="/PHP-BCTH/public/student/topics" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'topics' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-journal-bookmark-fill text-lg"></i>
            <span>Danh sách đề tài</span>
        </a>
        
        <a href="/PHP-BCTH/public/student/progress" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'progress' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-graph-up-arrow text-lg"></i>
            <span>Báo cáo tiến độ</span>
        </a>

        <a href="/PHP-BCTH/public/student/submission" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'submission' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-cloud-arrow-up-fill text-lg"></i>
            <span>Nộp bài đồ án</span>
        </a>
        
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">🔔 Tiện ích</p>
        
        <a href="/PHP-BCTH/public/student/notifications" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'notifications' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-bell-fill text-lg"></i>
            <span>Thông báo</span>
            <?php if (!empty($data['unread_count'])): ?>
            <span class="ml-auto px-2 py-0.5 bg-red-500 text-white text-xs rounded-full animate-pulse"><?= $data['unread_count'] ?></span>
            <?php endif; ?>
        </a>
        
        <a href="/PHP-BCTH/public/student/calendar" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'calendar' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-calendar-event-fill text-lg"></i>
            <span>Lịch & Deadline</span>
            <span class="ml-auto px-2 py-0.5 bg-amber-500/20 text-amber-400 text-xs rounded-full">Mới</span>
        </a>
        
        <a href="/PHP-BCTH/public/student/documents" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'documents' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-file-earmark-text-fill text-lg"></i>
            <span>Tài liệu mẫu</span>
            <span class="ml-auto px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded-full">Mới</span>
        </a>
        
        <a href="/PHP-BCTH/public/student/contact" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'contact' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-chat-dots-fill text-lg"></i>
            <span>Liên hệ GVHD</span>
        </a>
        
        <p class="text-xs text-gray-500 uppercase tracking-wider mt-6 mb-3 px-3 font-semibold">⚙️ Cài đặt</p>
        
        <a href="/PHP-BCTH/public/student/profile" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'profile' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-person-fill text-lg"></i>
            <span>Thông tin cá nhân</span>
        </a>
        
        <a href="/PHP-BCTH/public/student/changePassword" class="nav-item flex items-center gap-3 px-4 py-3 rounded-xl transition-all <?= $activePage == 'changePassword' ? 'bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg shadow-blue-500/30' : 'text-gray-300 hover:bg-white/5 hover:text-white' ?>">
            <i class="bi bi-shield-lock-fill text-lg"></i>
            <span>Đổi mật khẩu</span>
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
