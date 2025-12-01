<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
$reg = $data['registration'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiến độ sinh viên | TVU Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-50 via-emerald-50/30 to-teal-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/teacher_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <a href="<?= $basePath ?>/teacher/students" class="text-white/70 hover:text-white text-sm flex items-center gap-1 mb-2">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <h2 class="text-2xl font-bold">Theo dõi tiến độ</h2>
            </div>
        </div>
    </header>

    <div class="p-6 md:p-8 space-y-6">
        <!-- Thông tin sinh viên -->
        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center text-3xl font-bold">
                    <?= strtoupper(substr($reg['student_name'] ?? 'S', 0, 1)) ?>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold"><?= htmlspecialchars($reg['student_name'] ?? 'Sinh viên') ?></h3>
                    <p class="text-white/80">Mã SV: <?= htmlspecialchars($reg['student_code'] ?? '') ?></p>
                    <p class="text-white/80 text-sm mt-1"><?= htmlspecialchars($reg['student_email'] ?? '') ?></p>
                </div>
                <div class="text-right">
                    <p class="text-white/70 text-sm">Đề tài</p>
                    <p class="font-semibold"><?= htmlspecialchars($reg['topic_title'] ?? 'Chưa có') ?></p>
                </div>
            </div>
        </div>

        <!-- Báo cáo tiến độ 4 tuần -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-graph-up text-blue-500"></i> Báo cáo tiến độ 4 tuần
                </h3>
            </div>
            <div class="p-6">
                <?php if (empty($data['reports'])): ?>
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-exclamation-triangle text-3xl text-amber-500"></i>
                    </div>
                    <p class="text-gray-500">Sinh viên chưa báo cáo tiến độ</p>
                </div>
                <?php else: ?>
                <div class="space-y-6">
                    <?php for ($week = 1; $week <= 4; $week++): 
                        $weekReports = array_filter($data['reports'], fn($r) => $r['week_number'] == $week);
                    ?>
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 font-semibold text-gray-700 flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-500 text-white rounded-lg flex items-center justify-center text-sm"><?= $week ?></span>
                            Tuần <?= $week ?>
                        </div>
                        <?php if (empty($weekReports)): ?>
                        <div class="p-4 text-center text-gray-400 text-sm">Chưa có báo cáo</div>
                        <?php else: ?>
                        <div class="divide-y divide-gray-100">
                            <?php foreach ($weekReports as $report): ?>
                            <div class="p-4 flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($report['task_name']) ?></p>
                                    <?php if ($report['note']): ?>
                                    <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($report['note']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium <?= $report['status'] === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?>">
                                        <?= $report['status'] === 'completed' ? '✓ Hoàn thành' : '⏳ Đang làm' ?>
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y', strtotime($report['updated_at'])) ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bài nộp -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-violet-50 to-purple-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-cloud-upload text-violet-500"></i> Bài nộp của sinh viên
                </h3>
            </div>
            <div class="p-6">
                <?php if (!$data['submission']): ?>
                <div class="text-center py-10">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-cloud-slash text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500">Sinh viên chưa nộp bài</p>
                </div>
                <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <a href="<?= htmlspecialchars($data['submission']['google_drive_link']) ?>" target="_blank" class="p-5 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl text-white hover:shadow-lg transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-google text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold">Google Drive</p>
                                <p class="text-white/80 text-sm">Xem báo cáo, video</p>
                            </div>
                            <i class="bi bi-box-arrow-up-right ml-auto"></i>
                        </div>
                    </a>
                    <a href="<?= htmlspecialchars($data['submission']['github_link']) ?>" target="_blank" class="p-5 bg-gradient-to-r from-gray-800 to-gray-900 rounded-xl text-white hover:shadow-lg transition-all group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="bi bi-github text-2xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold">GitHub</p>
                                <p class="text-white/80 text-sm">Xem mã nguồn</p>
                            </div>
                            <i class="bi bi-box-arrow-up-right ml-auto"></i>
                        </div>
                    </a>
                </div>
                <?php if ($data['submission']['note']): ?>
                <div class="p-4 bg-gray-50 rounded-xl mb-4">
                    <p class="text-sm text-gray-500 mb-1">Ghi chú từ sinh viên:</p>
                    <p class="text-gray-700"><?= nl2br(htmlspecialchars($data['submission']['note'])) ?></p>
                </div>
                <?php endif; ?>
                <p class="text-sm text-gray-400"><i class="bi bi-clock"></i> Nộp lúc: <?= date('d/m/Y H:i', strtotime($data['submission']['submitted_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form góp ý -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-chat-dots text-blue-500"></i> Gửi góp ý cho sinh viên
                </h3>
            </div>
            <div class="p-6">
                <form method="POST" action="<?= $basePath ?>/teacher/sendNotification" class="space-y-4">
                    <input type="hidden" name="student_id" value="<?= $reg['student_id'] ?? '' ?>">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề</label>
                        <input type="text" name="title" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 outline-none" placeholder="Nhập tiêu đề góp ý" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung</label>
                        <textarea name="content" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-blue-500 outline-none resize-none" placeholder="Nhập nội dung góp ý..." required></textarea>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl transition-all flex items-center gap-2">
                        <i class="bi bi-send"></i> Gửi góp ý
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
