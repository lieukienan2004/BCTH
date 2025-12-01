<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Giảng viên | TVU Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/teacher_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\" fill=\"rgba(255,255,255,0.07)\"%3E%3C/path%3E%3C/svg%3E')]"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-64 h-64 bg-cyan-400/20 rounded-full translate-y-1/2 blur-2xl"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <p class="text-blue-100 text-sm mb-1">Xin chào, <?= $_SESSION['full_name'] ?? 'Giảng viên' ?> 👋</p>
                <h2 class="text-2xl font-bold">Dashboard Giảng viên</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur rounded-xl text-white/80 text-sm">
                    <i class="bi bi-calendar3"></i>
                    <?= date('d/m/Y') ?>
                </div>
                <button class="relative p-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all">
                    <i class="bi bi-bell text-xl"></i>
                </button>
                <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center text-white font-bold border-2 border-white/30 shadow-lg">
                    <?= $userInitial ?>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6 md:p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1: Đề tài -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl shadow-emerald-500/5 border border-white hover:shadow-2xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Đề tài của tôi</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mt-2"><?= $data['total_topics'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-2">đề tài đã tạo</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        <i class="bi bi-journal-bookmark text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Card 2: Sinh viên -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl shadow-blue-500/5 border border-white hover:shadow-2xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Sinh viên hướng dẫn</p>
                        <p class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mt-2"><?= $data['total_students'] ?? 0 ?></p>
                        <p class="text-xs text-gray-400 mt-2">sinh viên đang hướng dẫn</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <i class="bi bi-people-fill text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Card 3: Chờ duyệt -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl shadow-amber-500/5 border border-white hover:shadow-2xl hover:shadow-amber-500/10 hover:-translate-y-1 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Chờ duyệt</p>
                        <?php $pendingCount = isset($data['registrations']) ? count(array_filter($data['registrations'], fn($r) => $r['status'] === 'pending')) : 0; ?>
                        <p class="text-4xl font-bold bg-gradient-to-r from-amber-500 to-orange-500 bg-clip-text text-transparent mt-2"><?= $pendingCount ?></p>
                        <p class="text-xs text-gray-400 mt-2">đăng ký cần xử lý</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-500/30 group-hover:scale-110 transition-transform <?= $pendingCount > 0 ? 'animate-pulse' : '' ?>">
                        <i class="bi bi-hourglass-split text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Card 4: Đã duyệt -->
            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl p-6 shadow-xl shadow-violet-500/5 border border-white hover:shadow-2xl hover:shadow-violet-500/10 hover:-translate-y-1 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Đã duyệt</p>
                        <?php $approvedCount = isset($data['registrations']) ? count(array_filter($data['registrations'], fn($r) => $r['status'] === 'approved')) : 0; ?>
                        <p class="text-4xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent mt-2"><?= $approvedCount ?></p>
                        <p class="text-xs text-gray-400 mt-2">đăng ký đã duyệt</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-violet-500/30 group-hover:scale-110 transition-transform">
                        <i class="bi bi-check-circle-fill text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <a href="<?= $basePath ?>/teacher/createTopic" class="group flex flex-col items-center gap-3 p-5 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl text-white shadow-lg shadow-emerald-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-plus-lg text-2xl"></i>
                </div>
                <span class="font-semibold text-sm">Tạo đề tài mới</span>
            </a>
            <a href="<?= $basePath ?>/teacher/registrations" class="group flex flex-col items-center gap-3 p-5 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl text-white shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-clipboard-check text-2xl"></i>
                </div>
                <span class="font-semibold text-sm">Duyệt đăng ký</span>
            </a>
            <a href="<?= $basePath ?>/teacher/students" class="group flex flex-col items-center gap-3 p-5 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl text-white shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-people text-2xl"></i>
                </div>
                <span class="font-semibold text-sm">Xem sinh viên</span>
            </a>
            <a href="<?= $basePath ?>/teacher/sendNotificationForm" class="group flex flex-col items-center gap-3 p-5 bg-gradient-to-br from-violet-500 to-purple-500 rounded-2xl text-white shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="bi bi-send text-2xl"></i>
                </div>
                <span class="font-semibold text-sm">Gửi thông báo</span>
            </a>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Đề tài của tôi -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-emerald-500/5 border border-white overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                            <i class="bi bi-journal-bookmark"></i>
                        </div>
                        Đề tài của tôi
                    </h3>
                    <a href="<?= $basePath ?>/teacher/topics" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center gap-1">
                        Xem tất cả <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="p-5">
                    <?php if (empty($data['topics'])): ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-journal-x text-3xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 mb-4">Bạn chưa có đề tài nào</p>
                        <a href="<?= $basePath ?>/teacher/createTopic" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 text-white rounded-xl hover:bg-emerald-600 transition-all text-sm font-medium">
                            <i class="bi bi-plus-lg"></i> Tạo đề tài mới
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach (array_slice($data['topics'], 0, 5) as $topic): ?>
                        <div class="p-4 bg-gray-50 hover:bg-emerald-50 rounded-xl transition-all group cursor-pointer">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate group-hover:text-emerald-700 transition-colors"><?= htmlspecialchars($topic['title']) ?></h4>
                                    <div class="flex items-center gap-3 mt-2 text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="bi bi-people"></i>
                                            <?= $topic['current_students'] ?>/<?= $topic['max_students'] ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="bi bi-calendar3"></i>
                                            <?= date('d/m/Y', strtotime($topic['created_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?= $topic['status'] === 'approved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' ?>">
                                    <?= $topic['status'] === 'approved' ? '✓ Đã duyệt' : '⏳ Chờ duyệt' ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sinh viên đăng ký gần đây -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-blue-500/5 border border-white overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        Đăng ký gần đây
                    </h3>
                    <a href="<?= $basePath ?>/teacher/registrations" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                        Xem tất cả <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="p-5">
                    <?php if (empty($data['registrations'])): ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-person-x text-3xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500">Chưa có sinh viên đăng ký</p>
                    </div>
                    <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach (array_slice($data['registrations'], 0, 5) as $reg): ?>
                        <div class="p-4 bg-gray-50 hover:bg-blue-50 rounded-xl transition-all group">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                    <?= strtoupper(substr($reg['student_name'] ?? 'S', 0, 1)) ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-800 truncate"><?= htmlspecialchars($reg['student_name'] ?? 'Sinh viên') ?></h4>
                                    <p class="text-sm text-gray-500 truncate"><?= htmlspecialchars($reg['topic_title'] ?? '') ?></p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium flex-shrink-0 <?= $reg['status'] === 'approved' ? 'bg-emerald-100 text-emerald-700' : ($reg['status'] === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') ?>">
                                    <?= $reg['status'] === 'approved' ? '✓ Đã duyệt' : ($reg['status'] === 'pending' ? '⏳ Chờ duyệt' : '✗ Từ chối') ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

</body>
</html>
