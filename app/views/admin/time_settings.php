<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$adminInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'A', 0, 1, 'UTF-8'), 'UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cài đặt thời gian | TVU Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { 'inter': ['Inter', 'sans-serif'] } } } }</script>
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-100 via-amber-50/30 to-orange-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-amber-500 via-orange-500 to-red-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">⏰</span><h2 class="text-xl font-bold">Cài đặt thời gian</h2></div>
                <p class="text-white/80 text-sm">Quản lý thời gian đăng ký đề tài</p>
            </div>
            <button onclick="openAddModal()" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-xl transition-all flex items-center gap-2">
                <i class="bi bi-plus-circle"></i> Thêm cài đặt
            </button>
        </div>
    </header>

    <div class="p-6 lg:p-8">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-check-circle-fill text-green-500 text-xl"></i>
            <p class="text-green-700"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <i class="bi bi-exclamation-circle-fill text-red-500 text-xl"></i>
            <p class="text-red-700"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
        </div>
        <?php endif; ?>

        <!-- Time Settings Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php if (!empty($data['settings'])): ?>
            <?php foreach ($data['settings'] as $setting): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-amber-50 to-orange-50">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-calendar-event text-amber-500"></i>
                        <?= htmlspecialchars($setting['setting_name']) ?>
                    </h3>
                    <?php if ($setting['is_active']): ?>
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        Đang hoạt động
                    </span>
                    <?php else: ?>
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-sm font-medium rounded-full">
                        Không hoạt động
                    </span>
                    <?php endif; ?>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($setting['description'] ?? 'Không có mô tả') ?></p>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="p-4 bg-green-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                                <i class="bi bi-play-circle text-green-500"></i> Bắt đầu
                            </p>
                            <p class="font-bold text-gray-800"><?= date('d/m/Y', strtotime($setting['start_date'])) ?></p>
                            <p class="text-sm text-gray-600"><?= date('H:i', strtotime($setting['start_date'])) ?></p>
                        </div>
                        <div class="p-4 bg-red-50 rounded-xl">
                            <p class="text-sm text-gray-500 mb-1 flex items-center gap-1">
                                <i class="bi bi-stop-circle text-red-500"></i> Kết thúc
                            </p>
                            <p class="font-bold text-gray-800"><?= date('d/m/Y', strtotime($setting['end_date'])) ?></p>
                            <p class="text-sm text-gray-600"><?= date('H:i', strtotime($setting['end_date'])) ?></p>
                        </div>
                    </div>
                    
                    <?php
                    $now = time();
                    $start = strtotime($setting['start_date']);
                    $end = strtotime($setting['end_date']);
                    $progress = 0;
                    $statusText = '';
                    $statusColor = '';
                    
                    if ($now < $start) {
                        $statusText = 'Chưa bắt đầu';
                        $statusColor = 'amber';
                    } elseif ($now > $end) {
                        $statusText = 'Đã kết thúc';
                        $statusColor = 'gray';
                        $progress = 100;
                    } else {
                        $statusText = 'Đang diễn ra';
                        $statusColor = 'green';
                        $progress = (($now - $start) / ($end - $start)) * 100;
                    }
                    ?>
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-500">Tiến độ</span>
                            <span class="text-sm font-medium text-<?= $statusColor ?>-600"><?= $statusText ?></span>
                        </div>
                        <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full transition-all" style="width: <?= $progress ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <button onclick="openEditModal(<?= htmlspecialchars(json_encode($setting)) ?>)" 
                            class="flex-1 py-2.5 bg-amber-100 hover:bg-amber-200 text-amber-700 font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-pencil"></i> Sửa
                        </button>
                        <a href="<?= $basePath ?>/admin/deleteTimeSetting/<?= $setting['setting_id'] ?>" 
                            onclick="return confirm('Bạn có chắc muốn xóa cài đặt này?')"
                            class="py-2.5 px-4 bg-red-100 hover:bg-red-200 text-red-700 font-medium rounded-xl transition-all flex items-center justify-center">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-span-full">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="w-20 h-20 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="bi bi-clock text-amber-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Chưa có cài đặt thời gian</h3>
                    <p class="text-gray-500 mb-4">Thêm cài đặt để quản lý thời gian đăng ký đề tài</p>
                    <button onclick="openAddModal()" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        <i class="bi bi-plus-circle mr-2"></i>Thêm cài đặt
                    </button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Add/Edit Modal -->
<div id="timeModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6">
                <h3 id="modalTitle" class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-clock"></i>
                    Thêm cài đặt thời gian
                </h3>
            </div>
            <form id="timeForm" method="POST" action="<?= $basePath ?>/admin/saveTimeSetting" class="p-6 space-y-4">
                <input type="hidden" name="setting_id" id="settingId">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tên cài đặt <span class="text-red-500">*</span></label>
                    <input type="text" name="setting_name" id="settingName" 
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all" 
                        placeholder="VD: Đăng ký đề tài HK1 2024" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mô tả</label>
                    <textarea name="description" id="settingDesc" rows="2"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all resize-none" 
                        placeholder="Mô tả ngắn về cài đặt này..."></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ngày bắt đầu <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="start_date" id="startDate" 
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ngày kết thúc <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="end_date" id="endDate" 
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all" required>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="isActive" value="1" class="w-5 h-5 text-amber-500 rounded">
                    <label for="isActive" class="text-gray-700">Kích hoạt ngay</label>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closeModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Hủy</button>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        <i class="bi bi-check-lg mr-2"></i>Lưu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').innerHTML = '<i class="bi bi-plus-circle"></i> Thêm cài đặt thời gian';
    document.getElementById('settingId').value = '';
    document.getElementById('settingName').value = '';
    document.getElementById('settingDesc').value = '';
    document.getElementById('startDate').value = '';
    document.getElementById('endDate').value = '';
    document.getElementById('isActive').checked = true;
    document.getElementById('timeModal').classList.remove('hidden');
}

function openEditModal(setting) {
    document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil"></i> Sửa cài đặt thời gian';
    document.getElementById('settingId').value = setting.setting_id;
    document.getElementById('settingName').value = setting.setting_name;
    document.getElementById('settingDesc').value = setting.description || '';
    document.getElementById('startDate').value = setting.start_date.replace(' ', 'T').slice(0, 16);
    document.getElementById('endDate').value = setting.end_date.replace(' ', 'T').slice(0, 16);
    document.getElementById('isActive').checked = setting.is_active == 1;
    document.getElementById('timeModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('timeModal').classList.add('hidden');
}
</script>

</body>
</html>
