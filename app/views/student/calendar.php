<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
$registration = $data['registration'] ?? null;

// Tính các mốc thời gian dựa trên ngày đăng ký
$steps = [];
if ($registration) {
    $registerDate = strtotime($registration['registered_at'] ?? $registration['created_at']);
    $steps = [
        ['step' => 1, 'title' => 'Đăng ký đề tài', 'date' => date('d/m/Y', $registerDate), 'status' => 'done', 'icon' => 'bi-journal-check', 'color' => 'emerald', 'desc' => 'Bạn đã đăng ký đề tài thành công'],
        ['step' => 2, 'title' => 'Báo cáo tuần 1', 'date' => date('d/m/Y', strtotime('+7 days', $registerDate)), 'deadline' => strtotime('+7 days', $registerDate), 'status' => time() > strtotime('+7 days', $registerDate) ? 'done' : (time() > strtotime('+5 days', $registerDate) ? 'warning' : 'pending'), 'icon' => 'bi-1-circle', 'color' => 'blue', 'desc' => 'Nộp báo cáo tiến độ tuần đầu tiên'],
        ['step' => 3, 'title' => 'Báo cáo tuần 2', 'date' => date('d/m/Y', strtotime('+14 days', $registerDate)), 'deadline' => strtotime('+14 days', $registerDate), 'status' => time() > strtotime('+14 days', $registerDate) ? 'done' : 'pending', 'icon' => 'bi-2-circle', 'color' => 'blue', 'desc' => 'Nộp báo cáo tiến độ tuần thứ 2'],
        ['step' => 4, 'title' => 'Báo cáo tuần 3', 'date' => date('d/m/Y', strtotime('+21 days', $registerDate)), 'deadline' => strtotime('+21 days', $registerDate), 'status' => time() > strtotime('+21 days', $registerDate) ? 'done' : 'pending', 'icon' => 'bi-3-circle', 'color' => 'blue', 'desc' => 'Nộp báo cáo tiến độ tuần thứ 3'],
        ['step' => 5, 'title' => 'Báo cáo tuần 4', 'date' => date('d/m/Y', strtotime('+28 days', $registerDate)), 'deadline' => strtotime('+28 days', $registerDate), 'status' => time() > strtotime('+28 days', $registerDate) ? 'done' : 'pending', 'icon' => 'bi-4-circle', 'color' => 'amber', 'desc' => 'Nộp báo cáo tiến độ tuần cuối'],
        ['step' => 6, 'title' => 'Nộp đồ án', 'date' => date('d/m/Y', strtotime('+35 days', $registerDate)), 'deadline' => strtotime('+35 days', $registerDate), 'status' => 'pending', 'icon' => 'bi-cloud-arrow-up', 'color' => 'violet', 'desc' => 'Nộp báo cáo và source code lên hệ thống'],
        ['step' => 7, 'title' => 'Bảo vệ đồ án', 'date' => date('d/m/Y', strtotime('+42 days', $registerDate)), 'deadline' => strtotime('+42 days', $registerDate), 'status' => 'pending', 'icon' => 'bi-trophy', 'color' => 'rose', 'desc' => 'Trình bày và bảo vệ trước hội đồng']
    ];
}

// Tìm deadline gần nhất
$nextDeadline = null;
foreach ($steps as $step) {
    if (isset($step['deadline']) && $step['deadline'] > time()) {
        $nextDeadline = $step;
        break;
    }
}

// Tính % hoàn thành
$completedSteps = 0;
foreach ($steps as $s) { if ($s['status'] === 'done') $completedSteps++; }
$progressPercent = count($steps) > 0 ? round(($completedSteps / count($steps)) * 100) : 0;
?>

<main class="lg:ml-72 min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Header với hiệu ứng đẹp hơn -->
    <header class="sticky top-0 z-30 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-6 py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\" fill=\"rgba(255,255,255,0.07)\"%3E%3C/path%3E%3C/svg%3E')] opacity-50"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pink-500/20 rounded-full translate-y-1/2 -translate-x-1/2 blur-2xl"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <i class="bi bi-kanban text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Tiến trình đồ án</h2>
                </div>
                <p class="text-white/80 text-sm ml-13">Theo dõi các bước thực hiện đồ án của bạn</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/PHP-BCTH/public/student/notifications" class="relative p-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all"><i class="bi bi-bell text-xl"></i></a>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 backdrop-blur rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center">
                            <img src="<?= $avatarPath ?>" alt="Avatar" class="w-full h-full object-cover" 
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="text-white text-lg font-bold hidden"><?= $userInitial ?></span>
                        </div>
                        <i class="bi bi-caret-down-fill text-white/80 text-xs transition-transform" id="dropdownArrow"></i>
                    </button>
                    <?php include_once __DIR__ . '/../layouts/user_dropdown.php'; ?>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6 md:p-8">
        <?php if (!$registration): ?>
        <!-- Chưa đăng ký đề tài - Card đẹp hơn -->
        <div class="max-w-2xl mx-auto">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl shadow-indigo-500/10 p-10 text-center border border-white">
                <div class="w-28 h-28 bg-gradient-to-br from-amber-400 to-orange-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-amber-500/30 rotate-3 hover:rotate-0 transition-transform">
                    <i class="bi bi-journal-x text-5xl text-white"></i>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-3">Bạn chưa đăng ký đề tài</h2>
                <p class="text-gray-500 mb-8 text-lg">Hãy đăng ký một đề tài để xem tiến trình thực hiện đồ án của bạn.</p>
                <a href="/PHP-BCTH/public/student/topics" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-2xl hover:shadow-xl hover:shadow-blue-500/30 hover:-translate-y-1 transition-all">
                    <i class="bi bi-journal-plus text-xl"></i>
                    Đăng ký đề tài ngay
                </a>
            </div>
        </div>
        
        <?php else: ?>
        
        <div class="max-w-5xl mx-auto space-y-6">
            
            <!-- Card thông tin đề tài - Glassmorphism -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 rounded-3xl p-6 text-white shadow-2xl shadow-indigo-500/30">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-2xl"></div>
                
                <div class="relative flex flex-col md:flex-row md:items-center gap-6">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center flex-shrink-0 shadow-lg">
                        <i class="bi bi-journal-bookmark text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white/70 text-sm font-medium uppercase tracking-wider">Đề tài của bạn</p>
                        <h3 class="font-bold text-2xl mt-1 mb-3"><?= htmlspecialchars($registration['topic_title'] ?? 'Chưa có tên') ?></h3>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur rounded-full text-sm">
                                <i class="bi bi-person-circle"></i>
                                <?= htmlspecialchars($registration['teacher_name'] ?? 'Chưa có') ?>
                            </span>
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/20 backdrop-blur rounded-full text-sm">
                                <i class="bi bi-calendar-check"></i>
                                <?= date('d/m/Y', strtotime($registration['registered_at'] ?? $registration['created_at'])) ?>
                            </span>
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm <?= $registration['status'] === 'approved' ? 'bg-emerald-400/30' : 'bg-amber-400/30' ?>">
                                <?= $registration['status'] === 'approved' ? '<i class="bi bi-check-circle-fill"></i> Đã duyệt' : '<i class="bi bi-hourglass-split"></i> Chờ duyệt' ?>
                            </span>
                        </div>
                    </div>
                    <!-- Progress Circle -->
                    <div class="flex-shrink-0 text-center">
                        <div class="relative w-24 h-24">
                            <svg class="w-24 h-24 transform -rotate-90">
                                <circle cx="48" cy="48" r="40" stroke="rgba(255,255,255,0.2)" stroke-width="8" fill="none"/>
                                <circle cx="48" cy="48" r="40" stroke="white" stroke-width="8" fill="none" stroke-linecap="round" stroke-dasharray="251.2" stroke-dashoffset="<?= 251.2 - (251.2 * $progressPercent / 100) ?>"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold"><?= $progressPercent ?>%</span>
                            </div>
                        </div>
                        <p class="text-white/70 text-xs mt-1">Hoàn thành</p>
                    </div>
                </div>
            </div>

            <?php if ($nextDeadline): 
                $daysLeft = ceil(($nextDeadline['deadline'] - time()) / 86400);
                $hoursLeft = ceil((($nextDeadline['deadline'] - time()) % 86400) / 3600);
            ?>
            <!-- Countdown Card - Đẹp hơn -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl shadow-<?= $daysLeft <= 3 ? 'red' : 'amber' ?>-500/10 border border-white overflow-hidden">
                <div class="bg-gradient-to-r <?= $daysLeft <= 3 ? 'from-red-500 via-rose-500 to-pink-500' : 'from-amber-500 via-orange-500 to-red-500' ?> p-6 text-white">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center animate-pulse">
                                <i class="bi bi-alarm text-3xl"></i>
                            </div>
                            <div>
                                <p class="text-white/80 text-sm font-medium">⏰ Việc cần làm tiếp theo</p>
                                <h3 class="font-bold text-xl"><?= $nextDeadline['title'] ?></h3>
                                <p class="text-white/80 text-sm">Hạn chót: <?= $nextDeadline['date'] ?></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-center px-4 py-3 bg-white/20 backdrop-blur rounded-2xl min-w-[70px]">
                                <p class="text-3xl font-bold"><?= $daysLeft ?></p>
                                <p class="text-white/80 text-xs">ngày</p>
                            </div>
                            <div class="text-center px-4 py-3 bg-white/20 backdrop-blur rounded-2xl min-w-[70px]">
                                <p class="text-3xl font-bold"><?= $hoursLeft ?></p>
                                <p class="text-white/80 text-xs">giờ</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if ($daysLeft <= 3): ?>
                <div class="p-4 bg-red-50 border-t border-red-100">
                    <p class="text-red-600 font-medium text-center flex items-center justify-center gap-2">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Sắp đến hạn! Hãy hoàn thành sớm nhé.
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Timeline các bước - Thiết kế mới -->
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl shadow-indigo-500/10 border border-white overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-bold text-xl text-gray-800 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        Các bước thực hiện đồ án
                    </h3>
                </div>
                
                <div class="p-6">
                    <div class="relative">
                        <!-- Đường kẻ dọc gradient -->
                        <div class="absolute left-7 top-0 bottom-0 w-1 bg-gradient-to-b from-emerald-400 via-blue-400 to-violet-400 rounded-full"></div>
                        
                        <div class="space-y-4">
                            <?php foreach ($steps as $index => $step): 
                                $isDone = $step['status'] === 'done';
                                $isWarning = $step['status'] === 'warning';
                                $isCurrent = !$isDone && ($index === 0 || $steps[$index-1]['status'] === 'done');
                                
                                // Màu sắc theo trạng thái
                                $bgColor = $isDone ? 'from-emerald-500 to-green-500' : ($isWarning ? 'from-amber-500 to-orange-500' : ($isCurrent ? 'from-blue-500 to-cyan-500' : 'from-gray-300 to-gray-400'));
                                $shadowColor = $isDone ? 'emerald' : ($isWarning ? 'amber' : ($isCurrent ? 'blue' : 'gray'));
                            ?>
                            <div class="relative flex gap-5 group">
                                <!-- Icon với animation -->
                                <div class="relative z-10 w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 bg-gradient-to-br <?= $bgColor ?> text-white shadow-lg shadow-<?= $shadowColor ?>-500/30 <?= $isCurrent ? 'ring-4 ring-blue-200 animate-pulse' : '' ?> <?= $isWarning ? 'animate-bounce' : '' ?> transition-all group-hover:scale-110">
                                    <?php if ($isDone): ?>
                                        <i class="bi bi-check-lg text-2xl"></i>
                                    <?php else: ?>
                                        <i class="<?= $step['icon'] ?> text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Card nội dung -->
                                <div class="flex-1 pb-4">
                                    <div class="p-5 rounded-2xl transition-all hover:shadow-lg <?php 
                                        if ($isDone) echo 'bg-gradient-to-r from-emerald-50 to-green-50 border-2 border-emerald-200';
                                        elseif ($isWarning) echo 'bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-300 shadow-lg shadow-amber-500/20';
                                        elseif ($isCurrent) echo 'bg-gradient-to-r from-blue-50 to-cyan-50 border-2 border-blue-300 shadow-lg shadow-blue-500/20';
                                        else echo 'bg-gray-50 border border-gray-200';
                                    ?>">
                                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-bold px-2 py-0.5 rounded-full <?= $isDone ? 'bg-emerald-200 text-emerald-700' : ($isCurrent ? 'bg-blue-200 text-blue-700' : 'bg-gray-200 text-gray-600') ?>">
                                                        Bước <?= $step['step'] ?>
                                                    </span>
                                                </div>
                                                <h4 class="font-bold text-lg <?= $isDone ? 'text-emerald-800' : ($isCurrent ? 'text-blue-800' : 'text-gray-700') ?>">
                                                    <?= $step['title'] ?>
                                                </h4>
                                                <p class="text-sm mt-1 <?= $isDone ? 'text-emerald-600' : ($isCurrent ? 'text-blue-600' : 'text-gray-500') ?>">
                                                    <?= $step['desc'] ?>
                                                </p>
                                            </div>
                                            <div class="text-right flex-shrink-0">
                                                <p class="text-sm font-semibold <?= $isDone ? 'text-emerald-600' : ($isCurrent ? 'text-blue-600' : 'text-gray-500') ?>">
                                                    <i class="bi bi-calendar3 mr-1"></i><?= $step['date'] ?>
                                                </p>
                                                <?php if ($isDone): ?>
                                                    <span class="inline-flex items-center gap-1 text-xs text-emerald-500 font-medium mt-1"><i class="bi bi-check-circle-fill"></i> Hoàn thành</span>
                                                <?php elseif ($isWarning): ?>
                                                    <span class="inline-flex items-center gap-1 text-xs text-amber-600 font-bold mt-1 animate-pulse"><i class="bi bi-exclamation-triangle-fill"></i> Sắp đến hạn!</span>
                                                <?php elseif ($isCurrent): ?>
                                                    <span class="inline-flex items-center gap-1 text-xs text-blue-500 font-medium mt-1"><i class="bi bi-arrow-right-circle-fill"></i> Đang thực hiện</span>
                                                <?php else: ?>
                                                    <span class="text-xs text-gray-400 mt-1">Chưa đến</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                        <?php if ($isCurrent && $step['step'] >= 2 && $step['step'] <= 5): ?>
                                        <a href="/PHP-BCTH/public/student/progress" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all">
                                            <i class="bi bi-pencil-square"></i>
                                            Báo cáo tiến độ ngay
                                        </a>
                                        <?php elseif ($isCurrent && $step['step'] === 6): ?>
                                        <a href="/PHP-BCTH/public/student/submission" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-500 to-purple-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:shadow-violet-500/30 hover:-translate-y-0.5 transition-all">
                                            <i class="bi bi-cloud-upload"></i>
                                            Nộp đồ án ngay
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ghi chú - Card đẹp hơn -->
            <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-violet-50 rounded-3xl p-6 border border-blue-200/50 shadow-lg shadow-blue-500/5">
                <h3 class="font-bold text-blue-800 flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    Lưu ý quan trọng
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white/70 backdrop-blur rounded-2xl p-4 border border-blue-100 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-3">
                            <i class="bi bi-calendar-week text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-700">Mỗi tuần bạn cần báo cáo tiến độ công việc đã làm được</p>
                    </div>
                    <div class="bg-white/70 backdrop-blur rounded-2xl p-4 border border-blue-100 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mb-3">
                            <i class="bi bi-chat-dots text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-700">Liên hệ GVHD nếu gặp khó khăn trong quá trình thực hiện</p>
                    </div>
                    <div class="bg-white/70 backdrop-blur rounded-2xl p-4 border border-blue-100 hover:shadow-md transition-all">
                        <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center text-violet-600 mb-3">
                            <i class="bi bi-clock-history text-xl"></i>
                        </div>
                        <p class="text-sm text-gray-700">Nộp đồ án đúng hạn để được bảo vệ đúng lịch</p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
