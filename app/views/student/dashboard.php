<?php 
include_once __DIR__ . '/../layouts/student_header.php'; 
include_once __DIR__ . '/../layouts/student_sidebar_new.php';
$basePath = defined('BASE_PATH') ? BASE_PATH : '';

$quotes = [
    "Học tập chính là cách bạn tự trao quyền cho mình",
    "Thành công là tổng của những nỗ lực nhỏ được lặp lại mỗi ngày", 
    "Đừng sợ thất bại, hãy sợ không dám thử",
    "Kiến thức là sức mạnh, học hỏi là chìa khóa",
    "Mỗi ngày là một cơ hội mới để học điều mới"
];
$randomQuote = $quotes[array_rand($quotes)];
$daysVi = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
$monthsVi = ['', 'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
$dayOfWeek = $daysVi[date('w')];
$day = date('d');
$month = $monthsVi[intval(date('m'))];
$year = date('Y');
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$hour = date('H');
$greeting = $hour < 12 ? '🌅 Chào buổi sáng' : ($hour < 18 ? '☀️ Chào buổi chiều' : '🌙 Chào buổi tối');
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <!-- Header with Gradient -->
    <header class="sticky top-0 z-30 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-600 px-6 py-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-1/4 w-32 h-32 bg-white/10 rounded-full translate-y-1/2"></div>
        <div class="absolute top-1/2 right-1/3 w-20 h-20 bg-white/5 rounded-full"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <p class="text-white/80 text-sm mb-1"><?= $greeting ?></p>
                <h2 class="text-2xl font-bold mb-2"><?= $_SESSION['full_name'] ?? 'Sinh viên' ?> 👋</h2>
                <div class="flex items-center gap-4 text-sm">
                    <span class="flex items-center gap-1 text-white/80">
                        <i class="bi bi-calendar3"></i>
                        <?= $dayOfWeek ?>, <?= $day ?> <?= $month ?> <?= $year ?>
                    </span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="<?= $basePath ?>/student/notifications" class="relative p-3 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                    <i class="bi bi-bell text-xl"></i>
                    <?php if (!empty($data['notifications'])): ?>
                    <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                    <?php endif; ?>
                </a>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = $basePath . '/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-cyan-400 to-indigo-500 flex items-center justify-center">
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
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Card 1: Topic Status -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <i class="bi bi-journal-bookmark text-white text-xl"></i>
                    </div>
                    <?php if (!empty($data['my_registration'])): ?>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">Đã ĐK</span>
                    <?php else: ?>
                    <span class="px-2 py-1 bg-amber-100 text-amber-600 text-xs font-medium rounded-full">Chưa ĐK</span>
                    <?php endif; ?>
                </div>
                <h3 class="text-2xl font-bold text-gray-800"><?= $data['my_registration'] ? '1' : '0' ?></h3>
                <p class="text-sm text-gray-500">Đề tài đã đăng ký</p>
            </div>
            
            <!-- Card 2: Progress -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30">
                        <i class="bi bi-graph-up text-white text-xl"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-800"><?= isset($data['progress_count']) ? $data['progress_count'] : '0' ?>/4</h3>
                <p class="text-sm text-gray-500">Tuần đã báo cáo</p>
                <div class="mt-2 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full" style="width: <?= (isset($data['progress_count']) ? $data['progress_count'] : 0) * 25 ?>%"></div>
                </div>
            </div>
            
            <!-- Card 3: Notifications -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                        <i class="bi bi-bell text-white text-xl"></i>
                    </div>
                    <?php if (!empty($data['notifications'])): ?>
                    <span class="px-2 py-1 bg-red-100 text-red-600 text-xs font-medium rounded-full animate-pulse">Mới</span>
                    <?php endif; ?>
                </div>
                <h3 class="text-2xl font-bold text-gray-800"><?= count($data['notifications'] ?? []) ?></h3>
                <p class="text-sm text-gray-500">Thông báo mới</p>
            </div>
            
            <!-- Card 4: Submission -->
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-lg transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                        <i class="bi bi-cloud-upload text-white text-xl"></i>
                    </div>
                    <?php if (!empty($data['submission'])): ?>
                    <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded-full">✓</span>
                    <?php endif; ?>
                </div>
                <h3 class="text-2xl font-bold text-gray-800"><?= !empty($data['submission']) ? 'Đã nộp' : 'Chưa' ?></h3>
                <p class="text-sm text-gray-500">Trạng thái nộp bài</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Registration Status - Takes 2 columns -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-bookmark-star text-blue-500"></i>
                        Đề tài của tôi
                    </h2>
                    <a href="<?= $basePath ?>/student/topics" class="text-blue-600 text-sm hover:underline">Xem tất cả →</a>
                </div>
                <div class="p-6">
                    <?php if (!empty($data['my_registration'])): ?>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                    <i class="bi bi-journal-text text-white text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg"><?= $data['my_registration']['topic_title'] ?></h3>
                                    <p class="text-gray-500 text-sm">GVHD: <?= $data['my_registration']['teacher_name'] ?></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Ngày đăng ký</p>
                                    <p class="font-semibold text-gray-800"><?= date('d/m/Y', strtotime($data['my_registration']['created_at'])) ?></p>
                                </div>
                                <div class="p-3 bg-gray-50 rounded-xl">
                                    <p class="text-xs text-gray-500">Trạng thái</p>
                                    <?php if ($data['my_registration']['status'] === 'approved'): ?>
                                    <p class="font-semibold text-green-600">✓ Đã duyệt</p>
                                    <?php elseif ($data['my_registration']['status'] === 'pending'): ?>
                                    <p class="font-semibold text-amber-600">⏳ Chờ duyệt</p>
                                    <?php else: ?>
                                    <p class="font-semibold text-red-600">✗ Từ chối</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 md:w-48">
                            <a href="<?= $basePath ?>/student/progress" class="py-2.5 px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-xl text-center transition-all">
                                <i class="bi bi-graph-up mr-1"></i> Báo cáo tiến độ
                            </a>
                            <a href="<?= $basePath ?>/student/submission" class="py-2.5 px-4 bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium rounded-xl text-center transition-all">
                                <i class="bi bi-cloud-upload mr-1"></i> Nộp bài
                            </a>
                            <a href="<?= $basePath ?>/student/contact" class="py-2.5 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl text-center transition-all">
                                <i class="bi bi-chat-dots mr-1"></i> Liên hệ GVHD
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <div class="w-20 h-20 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <i class="bi bi-journal-x text-amber-500 text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Chưa đăng ký đề tài</h3>
                        <p class="text-gray-500 mb-4">Hãy chọn một đề tài phù hợp để bắt đầu</p>
                        <a href="<?= $basePath ?>/student/topics" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-medium rounded-xl hover:shadow-lg transition-all">
                            <i class="bi bi-plus-circle"></i> Đăng ký ngay
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Upcoming Deadlines -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-alarm text-red-500"></i>
                        Deadline sắp tới
                    </h2>
                    <a href="<?= $basePath ?>/student/calendar" class="text-blue-600 text-sm hover:underline">Xem lịch →</a>
                </div>
                <div class="p-4 space-y-3">
                    <?php
                    $deadlines = [
                        ['title' => 'Báo cáo tuần 1', 'date' => date('Y-m-d', strtotime('+3 days')), 'type' => 'report'],
                        ['title' => 'Báo cáo tuần 2', 'date' => date('Y-m-d', strtotime('+10 days')), 'type' => 'report'],
                        ['title' => 'Nộp đồ án', 'date' => date('Y-m-d', strtotime('+30 days')), 'type' => 'submission'],
                    ];
                    foreach ($deadlines as $dl):
                        $daysLeft = ceil((strtotime($dl['date']) - time()) / 86400);
                        $isUrgent = $daysLeft <= 3;
                    ?>
                    <div class="flex items-center gap-3 p-3 <?= $isUrgent ? 'bg-red-50 border border-red-200' : 'bg-gray-50' ?> rounded-xl">
                        <div class="w-10 h-10 <?= $isUrgent ? 'bg-red-500' : 'bg-blue-500' ?> rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi <?= $dl['type'] === 'submission' ? 'bi-cloud-upload' : 'bi-file-text' ?> text-white"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 text-sm truncate"><?= $dl['title'] ?></p>
                            <p class="text-xs text-gray-500"><?= date('d/m/Y', strtotime($dl['date'])) ?></p>
                        </div>
                        <span class="px-2 py-1 <?= $isUrgent ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-600' ?> text-xs font-medium rounded-full">
                            <?= $daysLeft ?> ngày
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
            <a href="<?= $basePath ?>/student/topics" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-blue-200 transition-all text-center">
                <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-journal-bookmark text-blue-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Đề tài</p>
            </a>
            <a href="<?= $basePath ?>/student/progress" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-green-200 transition-all text-center">
                <div class="w-12 h-12 bg-green-100 group-hover:bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-graph-up-arrow text-green-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Tiến độ</p>
            </a>
            <a href="<?= $basePath ?>/student/submission" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-200 transition-all text-center">
                <div class="w-12 h-12 bg-purple-100 group-hover:bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-cloud-upload text-purple-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Nộp bài</p>
            </a>
            <a href="<?= $basePath ?>/student/calendar" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-red-200 transition-all text-center">
                <div class="w-12 h-12 bg-red-100 group-hover:bg-red-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-calendar-event text-red-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Lịch</p>
            </a>
            <a href="<?= $basePath ?>/student/documents" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-teal-200 transition-all text-center">
                <div class="w-12 h-12 bg-teal-100 group-hover:bg-teal-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-file-earmark-text text-teal-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Tài liệu</p>
            </a>
            <a href="<?= $basePath ?>/student/contact" class="group bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-lg hover:border-pink-200 transition-all text-center">
                <div class="w-12 h-12 bg-pink-100 group-hover:bg-pink-500 rounded-xl flex items-center justify-center mx-auto mb-3 transition-all">
                    <i class="bi bi-chat-dots text-pink-500 group-hover:text-white text-xl transition-all"></i>
                </div>
                <p class="font-medium text-gray-800 text-sm">Liên hệ</p>
            </a>
        </div>

        <!-- Bottom Section: Notifications & Guide -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Notifications -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-bell text-purple-500"></i>
                        Thông báo gần đây
                    </h2>
                    <a href="<?= $basePath ?>/student/notifications" class="text-blue-600 text-sm hover:underline">Xem tất cả →</a>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php if (!empty($data['notifications'])): ?>
                        <?php foreach (array_slice($data['notifications'], 0, 3) as $notif): ?>
                        <div class="p-4 hover:bg-gray-50 transition-all cursor-pointer">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="bi bi-envelope text-purple-600"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-800 text-sm truncate"><?= $notif['title'] ?></p>
                                    <p class="text-xs text-gray-500 mt-1"><?= date('d/m/Y H:i', strtotime($notif['created_at'])) ?></p>
                                </div>
                                <?php if (!$notif['is_read']): ?>
                                <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                    <div class="p-8 text-center text-gray-400">
                        <i class="bi bi-bell-slash text-3xl mb-2"></i>
                        <p class="text-sm">Chưa có thông báo</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Process Guide -->
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
                <h2 class="font-bold text-xl mb-4 flex items-center gap-2">
                    <i class="bi bi-signpost-split"></i>
                    Quy trình thực hiện đồ án
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                        <div>
                            <p class="font-semibold">Đăng ký đề tài</p>
                            <p class="text-white/70 text-sm">Chọn đề tài phù hợp với năng lực</p>
                        </div>
                        <?php if (!empty($data['my_registration'])): ?>
                        <i class="bi bi-check-circle-fill text-green-300 ml-auto"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                        <div>
                            <p class="font-semibold">Báo cáo tiến độ</p>
                            <p class="text-white/70 text-sm">Cập nhật tiến độ hàng tuần</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                        <div>
                            <p class="font-semibold">Nộp bài đồ án</p>
                            <p class="text-white/70 text-sm">Upload báo cáo và source code</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                        <div>
                            <p class="font-semibold">Bảo vệ đồ án</p>
                            <p class="text-white/70 text-sm">Trình bày trước hội đồng</p>
                        </div>
                    </div>
                </div>
                <a href="<?= $basePath ?>/student/documents" class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 rounded-xl transition-all text-sm">
                    <i class="bi bi-file-earmark-text"></i>
                    Xem tài liệu hướng dẫn
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
