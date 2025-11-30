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
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📋</span><h2 class="text-xl font-bold">Duyệt đăng ký</h2></div>
                <p class="text-white/80 text-sm">Quản lý đăng ký đề tài của sinh viên</p>
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
        
        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
            <p class="text-red-700"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div class="flex gap-2 mb-6 border-b border-gray-200">
            <button onclick="showTab('pending')" id="tab-pending" class="px-6 py-3 font-medium text-blue-600 border-b-2 border-blue-600 transition-all">
                <i class="bi bi-clock-history mr-2"></i>Chờ duyệt
                <?php $pendingCount = count(array_filter($data['registrations'] ?? [], fn($r) => $r['status'] === 'pending')); ?>
                <?php if ($pendingCount > 0): ?>
                <span class="ml-2 px-2 py-0.5 bg-amber-500 text-white text-xs rounded-full"><?= $pendingCount ?></span>
                <?php endif; ?>
            </button>
            <button onclick="showTab('approved')" id="tab-approved" class="px-6 py-3 font-medium text-gray-500 hover:text-blue-600 transition-all">
                <i class="bi bi-check-circle mr-2"></i>Đã duyệt
            </button>
            <button onclick="showTab('rejected')" id="tab-rejected" class="px-6 py-3 font-medium text-gray-500 hover:text-blue-600 transition-all">
                <i class="bi bi-x-circle mr-2"></i>Đã từ chối
            </button>
        </div>

        <!-- Tab Content: Pending -->
        <div id="content-pending" class="tab-content">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php $pendingRegs = array_filter($data['registrations'] ?? [], fn($r) => $r['status'] === 'pending'); ?>
                <?php if (!empty($pendingRegs)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">STT</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mã SV</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Đề tài</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Ngày ĐK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $i = 1; foreach ($pendingRegs as $reg): ?>
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm text-gray-600"><?= $i++ ?></td>
                                <td class="px-6 py-4"><span class="font-semibold text-gray-800"><?= $reg['student_code'] ?></span></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $reg['student_name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= $reg['student_email'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate"><?= $reg['topic_title'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= date('d/m/Y', strtotime($reg['registered_at'])) ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="/PHP-BCTH/public/teacher/approveRegistration/<?= $reg['registration_id'] ?>" 
                                           onclick="return confirm('Chấp nhận sinh viên <?= $reg['student_name'] ?>?')"
                                           class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg transition-all">
                                            <i class="bi bi-check-lg"></i> Duyệt
                                        </a>
                                        <a href="/PHP-BCTH/public/teacher/rejectRegistration/<?= $reg['registration_id'] ?>" 
                                           onclick="return confirm('Từ chối sinh viên <?= $reg['student_name'] ?>?')"
                                           class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-all">
                                            <i class="bi bi-x-lg"></i> Từ chối
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Không có đăng ký nào đang chờ duyệt</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab Content: Approved -->
        <div id="content-approved" class="tab-content hidden">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php $approvedRegs = array_filter($data['registrations'] ?? [], fn($r) => $r['status'] === 'approved'); ?>
                <?php if (!empty($approvedRegs)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">STT</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mã SV</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Đề tài</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $i = 1; foreach ($approvedRegs as $reg): ?>
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm text-gray-600"><?= $i++ ?></td>
                                <td class="px-6 py-4"><span class="font-semibold text-gray-800"><?= $reg['student_code'] ?></span></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $reg['student_name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= $reg['student_email'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $reg['topic_title'] ?></td>
                                <td class="px-6 py-4">
                                    <a href="/PHP-BCTH/public/teacher/progress/<?= $reg['registration_id'] ?>" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-all">
                                        <i class="bi bi-eye"></i> Xem tiến độ
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Chưa có sinh viên nào được duyệt</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tab Content: Rejected -->
        <div id="content-rejected" class="tab-content hidden">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php $rejectedRegs = array_filter($data['registrations'] ?? [], fn($r) => $r['status'] === 'rejected'); ?>
                <?php if (!empty($rejectedRegs)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">STT</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Mã SV</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Họ tên</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Đề tài</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $i = 1; foreach ($rejectedRegs as $reg): ?>
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm text-gray-600"><?= $i++ ?></td>
                                <td class="px-6 py-4"><span class="font-semibold text-gray-800"><?= $reg['student_code'] ?></span></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $reg['student_name'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?= $reg['student_email'] ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $reg['topic_title'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-inbox text-4xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Chưa có đăng ký nào bị từ chối</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script>
function showTab(tabName) {
    // Hide all content
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    // Reset all tabs
    document.querySelectorAll('[id^="tab-"]').forEach(el => {
        el.classList.remove('text-emerald-600', 'border-b-2', 'border-emerald-600');
        el.classList.add('text-gray-500');
    });
    // Show selected content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    // Highlight selected tab
    const tab = document.getElementById('tab-' + tabName);
    tab.classList.remove('text-gray-500');
    tab.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
}
</script>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
