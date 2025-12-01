<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$teacherInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
$isEdit = ($data['action'] ?? 'create') === 'edit';
$topic = $data['topic'] ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Chỉnh sửa đề tài' : 'Tạo đề tài mới' ?> | TVU Portal</title>
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
    <header class="sticky top-0 z-30 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xl"><?= $isEdit ? '✏️' : '➕' ?></span>
                    <h2 class="text-xl font-bold"><?= $isEdit ? 'Chỉnh sửa đề tài' : 'Tạo đề tài mới' ?></h2>
                </div>
                <p class="text-white/80 text-sm"><?= $isEdit ? 'Cập nhật thông tin đề tài' : 'Thêm đề tài mới cho sinh viên đăng ký' ?></p>
            </div>
            <a href="<?= $basePath ?>/teacher/topics" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl transition-all flex items-center gap-2">
                <i class="bi bi-arrow-left"></i>
                <span>Quay lại</span>
            </a>
        </div>
    </header>

    <div class="p-8">
        <div class="max-w-3xl mx-auto">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-4">
                    <h3 class="text-white font-bold flex items-center gap-2">
                        <i class="bi bi-journal-plus"></i>
                        Thông tin đề tài
                    </h3>
                </div>
                
                <form method="POST" class="p-6 space-y-5">
                    <!-- Tên đề tài -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-bookmark text-gray-400 mr-1"></i>
                            Tên đề tài <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" 
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:bg-white outline-none transition-all"
                            placeholder="Nhập tên đề tài..."
                            value="<?= htmlspecialchars($topic['title'] ?? '') ?>" required>
                    </div>
                    
                    <!-- Mô tả -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-file-text text-gray-400 mr-1"></i>
                            Mô tả đề tài <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="5"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:bg-white outline-none transition-all resize-none"
                            placeholder="Mô tả chi tiết về đề tài, mục tiêu, phạm vi..." required><?= htmlspecialchars($topic['description'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Mô tả chi tiết giúp sinh viên hiểu rõ hơn về đề tài</p>
                    </div>
                    
                    <!-- Yêu cầu -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-list-check text-gray-400 mr-1"></i>
                            Yêu cầu <span class="text-red-500">*</span>
                        </label>
                        <textarea name="requirements" rows="4"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:bg-white outline-none transition-all resize-none"
                            placeholder="Yêu cầu về kiến thức, kỹ năng cần có..." required><?= htmlspecialchars($topic['requirements'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-500 mt-1">Liệt kê các yêu cầu về kiến thức, kỹ năng sinh viên cần có</p>
                    </div>
                    
                    <!-- Số sinh viên tối đa -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-people text-gray-400 mr-1"></i>
                            Số sinh viên tối đa <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="max_students" min="1" max="5"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-emerald-500 focus:bg-white outline-none transition-all"
                            value="<?= $topic['max_students'] ?? 1 ?>" required>
                        <p class="text-xs text-gray-500 mt-1">Số lượng sinh viên có thể đăng ký đề tài này (1-5)</p>
                    </div>
                    
                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" 
                            class="flex-1 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/30 transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg"></i>
                            <?= $isEdit ? 'Cập nhật đề tài' : 'Tạo đề tài' ?>
                        </button>
                        <a href="<?= $basePath ?>/teacher/topics" 
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-x-lg"></i>
                            Hủy
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Tips -->
            <div class="mt-6 bg-blue-50 rounded-2xl p-6 border border-blue-200">
                <h3 class="font-bold text-blue-800 flex items-center gap-2 mb-3">
                    <i class="bi bi-lightbulb-fill text-blue-500"></i>
                    Mẹo tạo đề tài hay
                </h3>
                <ul class="space-y-2 text-sm text-blue-700">
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        Đặt tên đề tài rõ ràng, cụ thể và dễ hiểu
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        Mô tả chi tiết mục tiêu, phạm vi và kết quả mong đợi
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        Liệt kê rõ các yêu cầu về kiến thức và kỹ năng
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="bi bi-check-circle text-blue-500 mt-0.5"></i>
                        Đề tài nên phù hợp với thời gian và năng lực sinh viên
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>

</body>
</html>
