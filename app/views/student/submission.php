<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$hasSubmission = !empty($data['submission']);
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xl">☁️</span>
                    <h2 class="text-xl font-bold">Nộp bài đồ án</h2>
                    <?php if ($hasSubmission): ?>
                    <span class="px-2 py-0.5 bg-green-500 text-white text-xs font-bold rounded-full">✓ Đã nộp</span>
                    <?php endif; ?>
                </div>
                <p class="text-white/80 text-sm">Upload bài đồ án qua Google Drive và GitHub</p>
            </div>
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></button>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
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
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Topic Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="bi bi-journal-text text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Đề tài đang thực hiện</p>
                            <p class="font-bold text-gray-800"><?= $data['registration']['topic_title'] ?></p>
                            <p class="text-sm text-gray-600">GVHD: <?= $data['registration']['teacher_name'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Submission Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                        <h2 class="text-white font-bold flex items-center gap-2">
                            <i class="bi bi-cloud-upload-fill"></i>
                            <?= $hasSubmission ? 'Cập nhật bài nộp' : 'Nộp bài đồ án' ?>
                        </h2>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="/PHP-BCTH/public/student/submitProject" class="space-y-5">
                            <input type="hidden" name="registration_id" value="<?= $data['registration']['registration_id'] ?>">
                            
                            <!-- Google Drive Link -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-google text-red-500 mr-1"></i>Link Google Drive <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="bi bi-link-45deg absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="url" name="drive_link" 
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all" 
                                        placeholder="https://drive.google.com/..." 
                                        value="<?= $data['submission']['google_drive_link'] ?? '' ?>" required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Link chứa báo cáo, video demo, tài liệu</p>
                            </div>
                            
                            <!-- GitHub Link -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="bi bi-github mr-1"></i>Link GitHub Repository <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <i class="bi bi-link-45deg absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input type="url" name="github_link" 
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all" 
                                        placeholder="https://github.com/..." 
                                        value="<?= $data['submission']['github_link'] ?? '' ?>" required>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Link repository chứa mã nguồn</p>
                            </div>
                            
                            <!-- Notes -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Ghi chú</label>
                                <textarea name="notes" rows="4" 
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:bg-white outline-none transition-all resize-none" 
                                    placeholder="Ghi chú thêm về bài nộp (nếu có)..."><?= $data['submission']['note'] ?? '' ?></textarea>
                            </div>
                            
                            <button type="submit" class="w-full py-4 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold rounded-xl shadow-lg shadow-purple-500/30 transition-all flex items-center justify-center gap-2 text-lg">
                                <i class="bi bi-cloud-upload-fill"></i>
                                <?= $hasSubmission ? 'Cập nhật bài nộp' : 'Nộp bài' ?>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Instructions -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                    <h3 class="font-bold text-blue-800 flex items-center gap-2 mb-4">
                        <i class="bi bi-info-circle-fill text-blue-500"></i>
                        Hướng dẫn nộp bài
                    </h3>
                    <ul class="space-y-3 text-sm text-blue-700">
                        <li class="flex items-start gap-2">
                            <i class="bi bi-1-circle-fill text-blue-500 mt-0.5"></i>
                            <span>Tải báo cáo, video demo lên Google Drive</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-2-circle-fill text-blue-500 mt-0.5"></i>
                            <span>Đặt quyền truy cập "Anyone with the link"</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-3-circle-fill text-blue-500 mt-0.5"></i>
                            <span>Push mã nguồn lên GitHub repository</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="bi bi-4-circle-fill text-blue-500 mt-0.5"></i>
                            <span>Dán link vào form và nhấn Nộp bài</span>
                        </li>
                    </ul>
                </div>

                <!-- Submission Status -->
                <?php if ($hasSubmission): ?>
                <div class="bg-green-50 rounded-2xl p-6 border border-green-200">
                    <h3 class="font-bold text-green-800 flex items-center gap-2 mb-4">
                        <i class="bi bi-check-circle-fill text-green-500"></i>
                        Thông tin bài đã nộp
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-white rounded-xl">
                            <p class="text-gray-500 text-xs mb-1">Google Drive</p>
                            <a href="<?= $data['submission']['google_drive_link'] ?>" target="_blank" class="text-blue-600 hover:underline break-all text-xs">
                                <?= $data['submission']['google_drive_link'] ?>
                            </a>
                        </div>
                        <div class="p-3 bg-white rounded-xl">
                            <p class="text-gray-500 text-xs mb-1">GitHub</p>
                            <a href="<?= $data['submission']['github_link'] ?>" target="_blank" class="text-blue-600 hover:underline break-all text-xs">
                                <?= $data['submission']['github_link'] ?>
                            </a>
                        </div>
                        <div class="p-3 bg-white rounded-xl">
                            <p class="text-gray-500 text-xs mb-1">Ngày nộp</p>
                            <p class="font-semibold text-gray-800"><?= date('d/m/Y H:i', strtotime($data['submission']['submitted_at'])) ?></p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="bg-amber-50 rounded-2xl p-6 border border-amber-200">
                    <h3 class="font-bold text-amber-800 flex items-center gap-2 mb-2">
                        <i class="bi bi-exclamation-triangle-fill text-amber-500"></i>
                        Chưa nộp bài
                    </h3>
                    <p class="text-amber-700 text-sm">Hãy hoàn thành đồ án và nộp bài trước deadline.</p>
                </div>
                <?php endif; ?>

                <!-- Quick Links -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Liên kết hữu ích</h3>
                    <div class="space-y-2">
                        <a href="https://drive.google.com" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-google text-yellow-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Google Drive</span>
                            <i class="bi bi-box-arrow-up-right text-gray-400 ml-auto"></i>
                        </a>
                        <a href="https://github.com" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                            <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                                <i class="bi bi-github text-white"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">GitHub</span>
                            <i class="bi bi-box-arrow-up-right text-gray-400 ml-auto"></i>
                        </a>
                        <a href="/PHP-BCTH/public/student/documents" class="flex items-center gap-3 p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-file-earmark-text text-blue-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Tài liệu mẫu</span>
                            <i class="bi bi-chevron-right text-gray-400 ml-auto"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- No Registration -->
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
            <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-exclamation-triangle text-amber-500 text-3xl"></i>
            </div>
            <h3 class="font-bold text-amber-800 text-xl mb-2">Bạn chưa đăng ký đề tài</h3>
            <p class="text-amber-700 mb-4">Vui lòng đăng ký đề tài trước khi nộp bài</p>
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
