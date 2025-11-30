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
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">👥</span><h2 class="text-xl font-bold">Sinh viên hướng dẫn</h2></div>
                <p class="text-white/80 text-sm">Danh sách sinh viên bạn đang hướng dẫn</p>
            </div>
            <div class="flex items-center gap-4">
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

        <!-- Danh sách sinh viên -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <?php if (empty($data['registrations'])): ?>
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-people text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Chưa có sinh viên nào</h3>
                <p class="text-gray-500">Sinh viên sẽ xuất hiện ở đây sau khi đăng ký đề tài của bạn</p>
            </div>
            <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">STT</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mã SV</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Đề tài</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Trạng thái</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($data['registrations'] as $index => $reg): ?>
                        <tr class="hover:bg-gray-50 transition-all">
                            <td class="px-6 py-4 text-sm text-gray-600"><?= $index + 1 ?></td>
                            <td class="px-6 py-4"><span class="font-semibold text-gray-800"><?= htmlspecialchars($reg['student_code']) ?></span></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?= htmlspecialchars($reg['student_name']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= htmlspecialchars($reg['student_email']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate"><?= htmlspecialchars($reg['topic_title']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 bg-<?= $reg['status'] === 'approved' ? 'green' : 'amber' ?>-100 text-<?= $reg['status'] === 'approved' ? 'green' : 'amber' ?>-700 text-sm font-medium rounded-full">
                                    <?= $reg['status'] === 'approved' ? 'Đã duyệt' : 'Chờ duyệt' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="openNotifyModal(<?= $reg['student_id'] ?>, '<?= htmlspecialchars($reg['student_name']) ?>')" class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-all" title="Gửi thông báo">
                                        <i class="bi bi-bell"></i>
                                    </button>
                                    <a href="/PHP-BCTH/public/teacher/progress/<?= $reg['registration_id'] ?>" class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-all" title="Xem tiến độ">
                                        <i class="bi bi-graph-up"></i>
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

<!-- Modal gửi thông báo -->
<div id="notifyModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" onclick="closeNotifyModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-5 text-white">
                <h3 class="font-bold text-lg">Gửi thông báo đến <span id="studentName"></span></h3>
            </div>
            <form method="POST" action="/PHP-BCTH/public/teacher/sendNotification" class="p-6">
                <input type="hidden" name="student_id" id="studentId">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề</label>
                    <input type="text" name="title" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 outline-none" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung</label>
                    <textarea name="content" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 outline-none resize-none" required></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeNotifyModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all">Hủy</button>
                    <button type="submit" class="flex-1 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-all">Gửi thông báo</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openNotifyModal(studentId, studentName) {
    document.getElementById('studentId').value = studentId;
    document.getElementById('studentName').textContent = studentName;
    document.getElementById('notifyModal').classList.remove('hidden');
}
function closeNotifyModal() {
    document.getElementById('notifyModal').classList.add('hidden');
}
</script>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
