<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php $basePath = defined('BASE_PATH') ? BASE_PATH : ''; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$unreadCount = 0;
foreach ($data['notifications'] ?? [] as $n) {
    if (!$n['is_read']) $unreadCount++;
}
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-purple-500 via-violet-500 to-indigo-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xl">🔔</span>
                    <h2 class="text-xl font-bold">Thông báo</h2>
                    <?php if ($unreadCount > 0): ?>
                    <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-bold rounded-full"><?= $unreadCount ?> mới</span>
                    <?php endif; ?>
                </div>
                <p class="text-white/80 text-sm">Xem các thông báo từ giảng viên và hệ thống</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = $basePath . '/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-purple-400 to-violet-500 flex items-center justify-center">
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
        <!-- Filter Tabs -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <button onclick="filterNotifications('all')" class="notif-filter active px-4 py-2 rounded-xl font-medium bg-purple-500 text-white transition-all">
                    <i class="bi bi-inbox mr-1"></i> Tất cả (<?= count($data['notifications'] ?? []) ?>)
                </button>
                <button onclick="filterNotifications('unread')" class="notif-filter px-4 py-2 rounded-xl font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    <i class="bi bi-envelope mr-1"></i> Chưa đọc (<?= $unreadCount ?>)
                </button>
                <button onclick="filterNotifications('read')" class="notif-filter px-4 py-2 rounded-xl font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    <i class="bi bi-envelope-open mr-1"></i> Đã đọc (<?= count($data['notifications'] ?? []) - $unreadCount ?>)
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <?php if (!empty($data['notifications'])): ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($data['notifications'] as $notif): ?>
                <div class="notification-item p-5 hover:bg-gray-50 transition-all cursor-pointer <?= $notif['is_read'] ? 'read' : 'unread bg-purple-50/50' ?>" data-read="<?= $notif['is_read'] ? '1' : '0' ?>">
                    <div class="flex items-start gap-4">
                        <!-- Icon -->
                        <div class="w-12 h-12 <?= $notif['is_read'] ? 'bg-gray-100' : 'bg-purple-100' ?> rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bi <?= $notif['is_read'] ? 'bi-envelope-open text-gray-500' : 'bi-envelope-fill text-purple-500' ?> text-xl"></i>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($notif['title']) ?></h3>
                                <?php if (!$notif['is_read']): ?>
                                <span class="px-2 py-0.5 bg-red-500 text-white text-xs font-medium rounded-full animate-pulse">Mới</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2"><?= nl2br(htmlspecialchars($notif['content'])) ?></p>
                            <div class="flex items-center gap-4 text-xs text-gray-400">
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-person"></i>
                                    <?= $notif['sender_name'] ?? 'Hệ thống' ?>
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="bi bi-clock"></i>
                                    <?= date('d/m/Y H:i', strtotime($notif['created_at'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Status Indicator -->
                        <?php if (!$notif['is_read']): ?>
                        <div class="w-3 h-3 bg-purple-500 rounded-full flex-shrink-0 animate-pulse"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="py-20 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-bell-slash text-gray-400 text-4xl"></i>
                </div>
                <h3 class="font-bold text-gray-700 text-xl mb-2">Chưa có thông báo</h3>
                <p class="text-gray-500">Các thông báo từ giảng viên sẽ hiển thị ở đây</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
function filterNotifications(type) {
    document.querySelectorAll('.notif-filter').forEach(btn => {
        btn.classList.remove('bg-purple-500', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-600');
    });
    event.target.classList.remove('bg-gray-100', 'text-gray-600');
    event.target.classList.add('bg-purple-500', 'text-white');
    
    document.querySelectorAll('.notification-item').forEach(item => {
        const isRead = item.dataset.read === '1';
        if (type === 'all') item.style.display = '';
        else if (type === 'unread') item.style.display = isRead ? 'none' : '';
        else if (type === 'read') item.style.display = isRead ? '' : 'none';
    });
}
</script>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
