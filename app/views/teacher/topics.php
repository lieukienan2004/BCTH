<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/teacher_sidebar.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
$avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg';
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📚</span><h2 class="text-xl font-bold">Quản lý đề tài</h2></div>
                <p class="text-white/80 text-sm">Tạo và quản lý các đề tài đồ án</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/PHP-BCTH/public/teacher/createTopic" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Tạo đề tài mới
                </a>
                <div class="relative pl-4 border-l border-white/20">
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
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

    <div class="p-6">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
            <p class="text-red-700"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        </div>
        <?php endif; ?>

        <!-- Thống kê -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-info-circle-fill text-blue-500 text-xl"></i>
            <p class="text-blue-700">Bạn có thể tạo tối đa <strong>10 đề tài</strong>. Hiện tại: <strong><?= count($data['topics'] ?? []) ?>/10</strong></p>
        </div>

        <!-- Danh sách đề tài -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <?php if (empty($data['topics'])): ?>
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-journal-plus text-4xl text-blue-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có đề tài nào</h3>
                <p class="text-gray-500 mb-6">Hãy tạo đề tài đầu tiên của bạn!</p>
                <a href="/PHP-BCTH/public/teacher/createTopic" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-all">
                    <i class="bi bi-plus-circle"></i> Tạo đề tài mới
                </a>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">STT</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Tên đề tài</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mô tả</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Slot</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($data['topics'] as $index => $topic): ?>
                        <tr class="hover:bg-gray-50 transition-all">
                            <td class="px-6 py-4 text-sm text-gray-600"><?= $index + 1 ?></td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($topic['title']) ?></p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                <?= htmlspecialchars(substr($topic['description'] ?? '', 0, 60)) ?>...
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">
                                    <?= $topic['current_students'] ?>/<?= $topic['max_students'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php
                                $statusColors = ['pending' => 'amber', 'approved' => 'green', 'rejected' => 'red'];
                                $statusNames = ['pending' => 'Chờ duyệt', 'approved' => 'Đã duyệt', 'rejected' => 'Từ chối'];
                                $color = $statusColors[$topic['status']] ?? 'gray';
                                ?>
                                <span class="px-3 py-1 bg-<?= $color ?>-100 text-<?= $color ?>-700 text-sm font-medium rounded-full">
                                    <?= $statusNames[$topic['status']] ?? $topic['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/PHP-BCTH/public/teacher/editTopic/<?= $topic['topic_id'] ?>" class="p-2 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-all" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="/PHP-BCTH/public/teacher/deleteTopic/<?= $topic['topic_id'] ?>" onclick="return confirm('Bạn có chắc muốn xóa đề tài này?')" class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-all" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
