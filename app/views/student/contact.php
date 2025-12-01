<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php $basePath = defined('BASE_PATH') ? BASE_PATH : ''; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$registration = $data['registration'] ?? null;
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-violet-500 via-purple-500 to-fuchsia-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">💬</span><h2 class="text-xl font-bold">Liên hệ GVHD</h2></div>
                <p class="text-white/80 text-sm">Kết nối với giảng viên hướng dẫn của bạn</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></button>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = $basePath . '/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center">
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
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Teacher Info Card -->
            <div class="lg:col-span-1 space-y-6">
                <?php if ($registration): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-500 to-purple-500 p-6 text-center">
                        <div class="w-24 h-24 bg-white rounded-full mx-auto mb-4 flex items-center justify-center text-3xl font-bold text-purple-600 shadow-lg">
                            <?= strtoupper(substr($registration['teacher_name'], 0, 1)) ?>
                        </div>
                        <h3 class="font-bold text-white text-xl"><?= $registration['teacher_name'] ?></h3>
                        <p class="text-white/80">Giảng viên hướng dẫn</p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <i class="bi bi-envelope text-purple-500 text-xl"></i>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <a href="mailto:<?= $registration['teacher_email'] ?? '' ?>" class="text-purple-600 hover:underline font-medium">
                                    <?= $registration['teacher_email'] ?? 'Chưa cập nhật' ?>
                                </a>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <i class="bi bi-journal-text text-purple-500 text-xl"></i>
                            <div>
                                <p class="text-xs text-gray-500">Đề tài hướng dẫn</p>
                                <p class="font-medium text-gray-800"><?= $registration['topic_title'] ?></p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="mailto:<?= $registration['teacher_email'] ?? '' ?>" class="flex-1 py-3 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl text-center transition-all">
                                <i class="bi bi-envelope mr-2"></i>Gửi Email
                            </a>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="bi bi-exclamation-triangle text-amber-500 text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-amber-800 mb-2">Chưa có GVHD</h3>
                        <p class="text-amber-700 text-sm mb-4">Bạn cần đăng ký đề tài để được phân công giảng viên hướng dẫn.</p>
                        <a href="<?= $basePath ?>/student/topics" class="inline-block px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all">
                            Đăng ký đề tài
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Contact Options -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-lightning-charge text-amber-500"></i>
                        Liên hệ nhanh
                    </h3>
                    <div class="space-y-3">
                        <a href="#" class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="bi bi-facebook text-white"></i>
                            </div>
                            <span class="font-medium text-gray-700">Facebook Khoa CNTT</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 bg-sky-50 hover:bg-sky-100 rounded-xl transition-all">
                            <div class="w-10 h-10 bg-sky-500 rounded-lg flex items-center justify-center">
                                <i class="bi bi-telegram text-white"></i>
                            </div>
                            <span class="font-medium text-gray-700">Group Telegram SV</span>
                        </a>
                        <a href="tel:02943855246" class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-xl transition-all">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                                <i class="bi bi-telephone text-white"></i>
                            </div>
                            <span class="font-medium text-gray-700">Văn phòng Khoa</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Message Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-chat-square-text text-purple-500"></i>
                            Gửi tin nhắn cho GVHD
                        </h2>
                    </div>
                    <div class="p-6">
                        <?php if ($registration): ?>
                        <form method="POST" action="<?= $basePath ?>/student/sendMessage" class="space-y-4">
                            <input type="hidden" name="teacher_id" value="<?= $registration['teacher_id'] ?? '' ?>">
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Chủ đề <span class="text-red-500">*</span></label>
                                <select name="subject" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all" required>
                                    <option value="">-- Chọn chủ đề --</option>
                                    <option value="progress">Báo cáo tiến độ</option>
                                    <option value="question">Hỏi đáp về đề tài</option>
                                    <option value="meeting">Xin lịch hẹn gặp</option>
                                    <option value="extension">Xin gia hạn</option>
                                    <option value="other">Khác</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                                <input type="text" name="title" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all" placeholder="Nhập tiêu đề tin nhắn..." required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung <span class="text-red-500">*</span></label>
                                <textarea name="content" rows="6" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all resize-none" placeholder="Nhập nội dung tin nhắn..." required></textarea>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-500 hover:from-violet-600 hover:to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-purple-500/30 transition-all flex items-center gap-2">
                                    <i class="bi bi-send"></i>
                                    Gửi tin nhắn
                                </button>
                                <button type="reset" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all">
                                    Xóa nội dung
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <div class="text-center py-12 text-gray-400">
                            <i class="bi bi-chat-square-x text-5xl mb-4"></i>
                            <p>Vui lòng đăng ký đề tài để liên hệ với GVHD</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="bi bi-question-circle text-blue-500"></i>
                            Câu hỏi thường gặp
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="faq-item">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-all">
                                <span class="font-medium text-gray-800">Làm sao để liên hệ GVHD ngoài giờ hành chính?</span>
                                <i class="bi bi-chevron-down text-gray-400 transition-transform"></i>
                            </button>
                            <div class="faq-content hidden px-6 pb-4 text-gray-600 text-sm">
                                Bạn có thể gửi email hoặc tin nhắn qua hệ thống. GVHD sẽ phản hồi trong vòng 24-48 giờ làm việc.
                            </div>
                        </div>
                        <div class="faq-item">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-all">
                                <span class="font-medium text-gray-800">Tôi có thể xin đổi GVHD không?</span>
                                <i class="bi bi-chevron-down text-gray-400 transition-transform"></i>
                            </button>
                            <div class="faq-content hidden px-6 pb-4 text-gray-600 text-sm">
                                Việc đổi GVHD cần có lý do chính đáng và được sự đồng ý của cả hai bên. Vui lòng liên hệ văn phòng Khoa để được hướng dẫn.
                            </div>
                        </div>
                        <div class="faq-item">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 transition-all">
                                <span class="font-medium text-gray-800">Bao lâu thì GVHD phản hồi tin nhắn?</span>
                                <i class="bi bi-chevron-down text-gray-400 transition-transform"></i>
                            </button>
                            <div class="faq-content hidden px-6 pb-4 text-gray-600 text-sm">
                                Thông thường GVHD sẽ phản hồi trong vòng 1-2 ngày làm việc. Nếu có việc gấp, bạn nên gọi điện trực tiếp.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function toggleFaq(btn) {
    const content = btn.nextElementSibling;
    const icon = btn.querySelector('i');
    content.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
