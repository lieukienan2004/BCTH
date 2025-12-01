<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
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
<body class="font-inter bg-gradient-to-br from-slate-50 via-blue-50/30 to-cyan-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/teacher_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-6 py-5 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z\" fill=\"rgba(255,255,255,0.07)\"%3E%3C/path%3E%3C/svg%3E')]"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                        <i class="bi bi-graph-up-arrow text-xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold">Tiến độ sinh viên</h2>
                </div>
                <p class="text-white/80 text-sm">Theo dõi tiến độ thực hiện đồ án của sinh viên</p>
            </div>
        </div>
    </header>

    <div class="p-6 md:p-8">
        <?php if (empty($data['registrations'])): ?>
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-10 text-center shadow-xl border border-white">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-person-x text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Chưa có sinh viên</h3>
            <p class="text-gray-500">Bạn chưa có sinh viên nào đăng ký đề tài.</p>
        </div>
        <?php else: ?>
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white overflow-hidden">
            <div class="p-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-cyan-50">
                <h3 class="font-bold text-gray-800">Danh sách sinh viên đang hướng dẫn</h3>
            </div>
            <div class="divide-y divide-gray-100">
                <?php foreach ($data['registrations'] as $reg): 
                    if ($reg['status'] !== 'approved') continue;
                ?>
                <div class="p-5 hover:bg-blue-50/50 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            <?= strtoupper(substr($reg['student_name'] ?? 'S', 0, 1)) ?>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800"><?= htmlspecialchars($reg['student_name'] ?? 'Sinh viên') ?></h4>
                            <p class="text-sm text-gray-500"><?= htmlspecialchars($reg['topic_title'] ?? '') ?></p>
                            <p class="text-xs text-gray-400 mt-1">Đăng ký: <?= date('d/m/Y', strtotime($reg['registered_at'])) ?></p>
                        </div>
                        <a href="<?= $basePath ?>/teacher/progress/<?= $reg['registration_id'] ?>" class="px-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600 transition-all text-sm font-medium flex items-center gap-2">
                            <i class="bi bi-eye"></i> Xem tiến độ
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
