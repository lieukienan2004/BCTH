<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$progressCount = count($data['progress_reports'] ?? []);
$progressPercent = min(100, $progressCount * 25);
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📊</span><h2 class="text-xl font-bold">Báo cáo tiến độ</h2></div>
                <p class="text-white/80 text-sm">Cập nhật tiến độ thực hiện đồ án hàng tuần</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></button>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
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
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>

        <?php if (!empty($data['registration'])): ?>
        <!-- Progress Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Topic Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="bi bi-journal-text text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Đề tài đang thực hiện</p>
                        <p class="font-bold text-gray-800"><?= $data['registration']['topic_title'] ?></p>
                    </div>
                </div>
                <div class="p-3 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500">Giảng viên hướng dẫn</p>
                    <p class="font-semibold text-gray-800"><?= $data['registration']['teacher_name'] ?></p>
                </div>
            </div>
            
            <!-- Progress Circle -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center">
                <div class="relative w-32 h-32">
                    <svg class="w-full h-full transform -rotate-90">
                        <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="12" fill="none"/>
                        <circle cx="64" cy="64" r="56" stroke="url(#gradient)" stroke-width="12" fill="none" 
                            stroke-dasharray="352" stroke-dashoffset="<?= 352 - (352 * $progressPercent / 100) ?>" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" style="stop-color:#22c55e"/>
                                <stop offset="100%" style="stop-color:#14b8a6"/>
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-3xl font-bold text-gray-800"><?= $progressPercent ?>%</span>
                        <span class="text-xs text-gray-500">Hoàn thành</span>
                    </div>
                </div>
                <p class="mt-4 text-gray-600"><?= $progressCount ?>/4 tuần đã báo cáo</p>
            </div>
            
            <!-- Quick Stats -->
            <div class="bg-gradient-to-br from-green-500 to-teal-500 rounded-2xl p-6 text-white">
                <h3 class="font-bold mb-4 flex items-center gap-2"><i class="bi bi-lightning-charge"></i> Thống kê nhanh</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl">
                        <span>Tuần đã báo cáo</span>
                        <span class="font-bold"><?= $progressCount ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl">
                        <span>Tuần còn lại</span>
                        <span class="font-bold"><?= max(0, 4 - $progressCount) ?></span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-white/10 rounded-xl">
                        <span>Trạng thái</span>
                        <span class="font-bold"><?= $progressCount >= 4 ? '✓ Đủ' : 'Đang thực hiện' ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Progress Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                <h2 class="text-white font-bold flex items-center gap-2"><i class="bi bi-plus-circle"></i> Thêm báo cáo tiến độ mới</h2>
            </div>
            <form method="POST" action="/PHP-BCTH/public/student/addProgress" class="p-6">
                <input type="hidden" name="registration_id" value="<?= $data['registration']['registration_id'] ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tuần thứ <span class="text-red-500">*</span></label>
                        <select name="week_number" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:bg-white outline-none transition-all" required>
                            <option value="">-- Chọn tuần --</option>
                            <?php for ($i = 1; $i <= 4; $i++): 
                                $reported = false;
                                foreach ($data['progress_reports'] as $r) {
                                    if ($r['week_number'] == $i) { $reported = true; break; }
                                }
                            ?>
                            <option value="<?= $i ?>" <?= $reported ? 'disabled' : '' ?>>Tuần <?= $i ?> <?= $reported ? '(Đã báo cáo)' : '' ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Trạng thái <span class="text-red-500">*</span></label>
                        <select name="status" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:bg-white outline-none transition-all" required>
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="completed">✓ Đã hoàn thành</option>
                            <option value="incomplete">⏳ Chưa hoàn thành</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tên công việc <span class="text-red-500">*</span></label>
                        <input type="text" name="task_name" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:bg-white outline-none transition-all" placeholder="VD: Phân tích yêu cầu" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả chi tiết</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:bg-white outline-none transition-all resize-none" placeholder="Mô tả chi tiết công việc đã thực hiện trong tuần..."></textarea>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 transition-all flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i> Thêm báo cáo
                </button>
            </form>
        </div>

        <!-- Progress Timeline -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="font-bold text-gray-800 flex items-center gap-2"><i class="bi bi-clock-history text-blue-500"></i> Lịch sử báo cáo tiến độ</h2>
            </div>
            <?php if (!empty($data['progress_reports'])): ?>
            <div class="p-6">
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    
                    <!-- Timeline Items -->
                    <div class="space-y-6">
                        <?php foreach ($data['progress_reports'] as $report): ?>
                        <div class="relative flex gap-6">
                            <!-- Timeline Dot -->
                            <div class="relative z-10 w-12 h-12 <?= $report['status'] === 'completed' ? 'bg-green-500' : 'bg-amber-500' ?> rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="text-white font-bold"><?= $report['week_number'] ?></span>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-all">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <h3 class="font-bold text-gray-800">Tuần <?= $report['week_number'] ?>: <?= $report['task_name'] ?></h3>
                                        <p class="text-sm text-gray-500"><?= date('d/m/Y H:i', strtotime($report['created_at'])) ?></p>
                                    </div>
                                    <?php if ($report['status'] === 'completed'): ?>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full flex items-center gap-1">
                                        <i class="bi bi-check-circle-fill"></i> Hoàn thành
                                    </span>
                                    <?php else: ?>
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-sm font-medium rounded-full flex items-center gap-1">
                                        <i class="bi bi-clock-fill"></i> Chưa xong
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($report['note'])): ?>
                                <p class="text-gray-600 text-sm"><?= nl2br($report['note']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-clipboard-x text-gray-400 text-3xl"></i>
                </div>
                <h3 class="font-bold text-gray-700 mb-2">Chưa có báo cáo tiến độ</h3>
                <p class="text-gray-500">Hãy thêm báo cáo tiến độ đầu tiên của bạn</p>
            </div>
            <?php endif; ?>
        </div>
        <?php else: ?>
        <!-- No Registration -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
            <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-exclamation-triangle text-amber-500 text-3xl"></i>
            </div>
            <h3 class="font-bold text-amber-800 text-xl mb-2">Bạn chưa đăng ký đề tài</h3>
            <p class="text-amber-700 mb-4">Vui lòng đăng ký đề tài trước khi báo cáo tiến độ</p>
            <a href="/PHP-BCTH/public/student/topics" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-all">
                <i class="bi bi-journal-plus"></i> Đăng ký đề tài ngay
            </a>
        </div>
        <?php endif; ?>
    </div>
</main>

<style>
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
