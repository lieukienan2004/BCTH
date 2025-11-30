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
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📨</span><h2 class="text-xl font-bold">Gửi thông báo</h2></div>
                <p class="text-white/80 text-sm">Gửi thông báo đến sinh viên của bạn</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/PHP-BCTH/public/teacher/students" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form gửi thông báo -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 px-6 py-4">
                        <h3 class="text-white font-bold flex items-center gap-2">
                            <i class="bi bi-bell-fill"></i> Tạo thông báo mới
                        </h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="/PHP-BCTH/public/teacher/sendNotification" class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Gửi đến <span class="text-red-500">*</span>
                                </label>
                                <select name="recipient_type" id="recipientType" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" required>
                                    <option value="">-- Chọn người nhận --</option>
                                    <option value="all">📢 Tất cả sinh viên của tôi</option>
                                    <option value="single">👤 Sinh viên cụ thể</option>
                                </select>
                            </div>
                            
                            <div id="studentSelect" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Chọn sinh viên
                                </label>
                                <select name="student_id" id="studentSelectInput" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all">
                                    <option value="">-- Chọn sinh viên --</option>
                                    <?php foreach ($data['students'] ?? [] as $student): ?>
                                    <option value="<?= $student['student_id'] ?>">
                                        <?= $student['student_name'] ?> (<?= $student['student_code'] ?>) - <?= $student['topic_title'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tiêu đề <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" placeholder="Nhập tiêu đề thông báo" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nội dung <span class="text-red-500">*</span>
                                </label>
                                <textarea name="content" rows="6" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all resize-none" placeholder="Nhập nội dung thông báo..." required></textarea>
                            </div>
                            
                            <div class="flex gap-3 pt-2">
                                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                                    <i class="bi bi-send-fill"></i> Gửi thông báo
                                </button>
                                <a href="/PHP-BCTH/public/teacher/students" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all flex items-center justify-center">
                                    Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar thông tin -->
            <div class="space-y-6">
                <!-- Hướng dẫn -->
                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                    <h3 class="font-bold text-blue-800 flex items-center gap-2 mb-3">
                        <i class="bi bi-info-circle-fill text-blue-500"></i> Hướng dẫn
                    </h3>
                    <div class="space-y-3 text-sm text-blue-700">
                        <div>
                            <p class="font-semibold">📢 Tất cả:</p>
                            <p>Gửi đến tất cả sinh viên đang thực hiện đề tài của bạn</p>
                        </div>
                        <div>
                            <p class="font-semibold">👤 Cụ thể:</p>
                            <p>Gửi đến một sinh viên cụ thể</p>
                        </div>
                    </div>
                </div>
                
                <!-- Danh sách sinh viên -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-5 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-people-fill text-blue-500"></i> Sinh viên của tôi
                        </h3>
                    </div>
                    <div class="p-5">
                        <p class="text-sm text-gray-600 mb-3">
                            <strong>Tổng số:</strong> <?= count($data['students'] ?? []) ?> sinh viên
                        </p>
                        <?php if (!empty($data['students'])): ?>
                        <div class="space-y-2">
                            <?php foreach (array_slice($data['students'], 0, 5) as $student): ?>
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold text-xs">
                                    <?= strtoupper(substr($student['student_name'], 0, 1)) ?>
                                </div>
                                <span class="text-gray-700"><?= $student['student_name'] ?></span>
                            </div>
                            <?php endforeach; ?>
                            <?php if (count($data['students']) > 5): ?>
                            <p class="text-xs text-gray-400 mt-2">... và <?= count($data['students']) - 5 ?> sinh viên khác</p>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">Chưa có sinh viên nào</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('recipientType').addEventListener('change', function() {
    const studentSelect = document.getElementById('studentSelect');
    const studentSelectInput = document.getElementById('studentSelectInput');
    
    if (this.value === 'single') {
        studentSelect.classList.remove('hidden');
        studentSelectInput.required = true;
    } else {
        studentSelect.classList.add('hidden');
        studentSelectInput.required = false;
        studentSelectInput.value = '';
    }
});
</script>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
