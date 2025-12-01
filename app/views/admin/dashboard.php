<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$adminInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'A', 0, 1, 'UTF-8'), 'UTF-8');
$daysVi = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
$monthsVi = ['', 'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | TVU Portal</title>
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
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-4px); }
    </style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-100 via-amber-50/30 to-orange-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <!-- Header -->
    <header class="sticky top-0 z-30 bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 px-6 py-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-1/4 w-64 h-64 bg-orange-500/10 rounded-full translate-y-1/2"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-shield-check text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Admin Dashboard</h2>
                        <p class="text-white/60 text-sm"><?= $daysVi[date('w')] ?>, <?= date('d') ?> <?= $monthsVi[intval(date('m'))] ?> <?= date('Y') ?></p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden md:block text-right text-white/80">
                    <p class="text-sm">Xin chào,</p>
                    <p class="font-semibold"><?= $_SESSION['full_name'] ?? 'Admin' ?></p>
                </div>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                    <?= $adminInitial ?>
                </div>
            </div>
        </div>
    </header>

    <div class="p-6 lg:p-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Students -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <i class="bi bi-people-fill text-white text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-xs font-semibold rounded-full">Sinh viên</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $data['total_students'] ?? 0 ?></h3>
                    <p class="text-gray-500 text-sm mt-1">Tổng sinh viên</p>
                </div>
            </div>

            <!-- Teachers -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30">
                            <i class="bi bi-person-badge-fill text-white text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-600 text-xs font-semibold rounded-full">Giảng viên</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $data['total_teachers'] ?? 0 ?></h3>
                    <p class="text-gray-500 text-sm mt-1">Tổng giảng viên</p>
                </div>
            </div>

            <!-- Topics -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-500 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                            <i class="bi bi-journal-bookmark-fill text-white text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-purple-100 text-purple-600 text-xs font-semibold rounded-full">Đề tài</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $data['total_topics'] ?? 0 ?></h3>
                    <p class="text-gray-500 text-sm mt-1">Tổng đề tài</p>
                </div>
            </div>

            <!-- Registrations -->
            <div class="stat-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-amber-500/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-500/30">
                            <i class="bi bi-clipboard-check-fill text-white text-2xl"></i>
                        </div>
                        <span class="px-3 py-1 bg-amber-100 text-amber-600 text-xs font-semibold rounded-full">Đăng ký</span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800"><?= $data['topic_stats']['total_registrations'] ?? 0 ?></h3>
                    <p class="text-gray-500 text-sm mt-1">Lượt đăng ký</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Topic Status -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-purple-500 to-violet-500">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="bi bi-pie-chart-fill"></i>
                        Trạng thái đề tài
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 flex items-center gap-2">
                                <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                Đã duyệt
                            </span>
                            <span class="font-bold text-green-600"><?= $data['topic_stats']['approved'] ?? 0 ?></span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 rounded-full transition-all" 
                                style="width: <?= $data['total_topics'] > 0 ? (($data['topic_stats']['approved'] ?? 0) / $data['total_topics'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 flex items-center gap-2">
                                <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                                Chờ duyệt
                            </span>
                            <span class="font-bold text-amber-600"><?= $data['topic_stats']['pending'] ?? 0 ?></span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full transition-all" 
                                style="width: <?= $data['total_topics'] > 0 ? (($data['topic_stats']['pending'] ?? 0) / $data['total_topics'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600 flex items-center gap-2">
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                                Từ chối
                            </span>
                            <span class="font-bold text-red-600"><?= $data['topic_stats']['rejected'] ?? 0 ?></span>
                        </div>
                        <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-red-400 to-rose-500 rounded-full transition-all" 
                                style="width: <?= $data['total_topics'] > 0 ? (($data['topic_stats']['rejected'] ?? 0) / $data['total_topics'] * 100) : 0 ?>%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Notifications -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-amber-500 to-orange-500">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <i class="bi bi-bell-fill"></i>
                        Thông báo hệ thống
                    </h3>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex items-start gap-3 p-4 bg-green-50 border border-green-200 rounded-xl">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-check-circle-fill text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-green-800">Hệ thống hoạt động bình thường</p>
                            <p class="text-green-600 text-sm">Tất cả dịch vụ đang chạy ổn định</p>
                        </div>
                    </div>
                    
                    <?php if (($data['topic_stats']['pending'] ?? 0) > 0): ?>
                    <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-exclamation-triangle-fill text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-800">Có <?= $data['topic_stats']['pending'] ?? 0 ?> đề tài chờ duyệt</p>
                            <p class="text-amber-600 text-sm">Vui lòng kiểm tra và phê duyệt</p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bi bi-info-circle-fill text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-800">Nhớ cài đặt thời gian đăng ký</p>
                            <p class="text-blue-600 text-sm">Thiết lập deadline cho sinh viên</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-lightning-charge-fill text-amber-500"></i>
                    Thao tác nhanh
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="<?= $basePath ?>/admin/createUser" class="group p-4 bg-gradient-to-br from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 rounded-xl border border-blue-200 transition-all text-center">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <i class="bi bi-person-plus-fill text-white text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-700">Thêm người dùng</p>
                    </a>
                    <a href="<?= $basePath ?>/admin/topics" class="group p-4 bg-gradient-to-br from-purple-50 to-violet-50 hover:from-purple-100 hover:to-violet-100 rounded-xl border border-purple-200 transition-all text-center">
                        <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <i class="bi bi-journal-check text-white text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-700">Duyệt đề tài</p>
                    </a>
                    <a href="<?= $basePath ?>/admin/users" class="group p-4 bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl border border-green-200 transition-all text-center">
                        <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <i class="bi bi-people-fill text-white text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-700">Quản lý users</p>
                    </a>
                    <a href="<?= $basePath ?>/admin/timeSettings" class="group p-4 bg-gradient-to-br from-amber-50 to-orange-50 hover:from-amber-100 hover:to-orange-100 rounded-xl border border-amber-200 transition-all text-center">
                        <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <i class="bi bi-clock-fill text-white text-xl"></i>
                        </div>
                        <p class="font-semibold text-gray-700">Cài đặt thời gian</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-8 py-6 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-sm text-gray-500">© <?= date('Y') ?> TVU Portal - Hệ thống quản lý đồ án CNTT</p>
        </div>
    </footer>
</main>

</body>
</html>
