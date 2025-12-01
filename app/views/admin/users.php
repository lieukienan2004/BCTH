<?php
$basePath = defined('BASE_PATH') ? BASE_PATH : '';
$adminInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'A', 0, 1, 'UTF-8'), 'UTF-8');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng | TVU Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config = { theme: { extend: { fontFamily: { 'inter': ['Inter', 'sans-serif'] } } } }</script>
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="font-inter bg-gradient-to-br from-slate-100 via-amber-50/30 to-orange-50/30 min-h-screen">

<?php include_once __DIR__ . '/../layouts/admin_sidebar.php'; ?>

<main class="lg:ml-72 min-h-screen">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">👥</span><h2 class="text-xl font-bold">Quản lý người dùng</h2></div>
                <p class="text-white/80 text-sm">Quản lý tài khoản sinh viên, giảng viên và admin</p>
            </div>
            <a href="<?= $basePath ?>/admin/createUser" class="px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-xl transition-all flex items-center gap-2">
                <i class="bi bi-plus-circle"></i> Thêm người dùng
            </a>
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

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-shield-check text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= $data['total_admins'] ?? 0 ?></p>
                        <p class="text-sm text-gray-500">Quản trị viên</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-person-badge text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= $data['total_teachers'] ?? 0 ?></p>
                        <p class="text-sm text-gray-500">Giảng viên</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                        <i class="bi bi-people text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= $data['total_students'] ?? 0 ?></p>
                        <p class="text-sm text-gray-500">Sinh viên</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <form method="GET" action="<?= $basePath ?>/admin/users" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vai trò</label>
                    <select name="role" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all">
                        <option value="all" <?= ($data['current_role'] ?? 'all') === 'all' ? 'selected' : '' ?>>Tất cả vai trò</option>
                        <option value="admin" <?= ($data['current_role'] ?? '') === 'admin' ? 'selected' : '' ?>>Quản trị viên</option>
                        <option value="teacher" <?= ($data['current_role'] ?? '') === 'teacher' ? 'selected' : '' ?>>Giảng viên</option>
                        <option value="student" <?= ($data['current_role'] ?? '') === 'student' ? 'selected' : '' ?>>Sinh viên</option>
                    </select>
                </div>
                <div class="flex-[2]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                    <input type="text" name="search" placeholder="Tìm theo tên, email, mã số..." 
                        value="<?= htmlspecialchars($data['current_search'] ?? '') ?>"
                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-amber-500 focus:bg-white outline-none transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        <i class="bi bi-search mr-2"></i>Tìm
                    </button>
                    <a href="<?= $basePath ?>/admin/users" class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Người dùng</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Vai trò</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Mã SV</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase">Ngày tạo</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (!empty($data['users'])): ?>
                        <?php foreach ($data['users'] as $user): ?>
                        <tr class="hover:bg-amber-50/50 transition-all">
                            <td class="px-6 py-4">
                                <span class="w-8 h-8 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center font-bold text-sm"><?= $user['user_id'] ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-white font-bold">
                                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($user['full_name']) ?></p>
                                        <p class="text-sm text-gray-500">@<?= htmlspecialchars($user['username']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <?php
                                $roleColors = ['admin' => 'red', 'teacher' => 'green', 'student' => 'blue'];
                                $roleNames = ['admin' => 'Quản trị', 'teacher' => 'Giảng viên', 'student' => 'Sinh viên'];
                                $color = $roleColors[$user['role']] ?? 'gray';
                                ?>
                                <span class="px-3 py-1.5 bg-<?= $color ?>-100 text-<?= $color ?>-700 text-sm font-medium rounded-full">
                                    <?= $roleNames[$user['role']] ?? $user['role'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600"><?= $user['student_code'] ?? '-' ?></td>
                            <td class="px-6 py-4 text-gray-600"><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?= $basePath ?>/admin/editUser/<?= $user['user_id'] ?>" 
                                        class="p-2 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg transition-all" title="Sửa">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="openDeleteModal(<?= $user['user_id'] ?>, '<?= addslashes($user['full_name']) ?>', '<?= $user['username'] ?>')" 
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-all" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <i class="bi bi-inbox text-4xl mb-2"></i>
                                <p>Không tìm thấy người dùng nào</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-rose-500 p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-exclamation-triangle text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Xác nhận xóa</h3>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">Bạn có chắc muốn xóa người dùng:</p>
                <div class="bg-red-50 rounded-xl p-4 mb-4">
                    <p class="font-semibold text-gray-800" id="deleteUserName"></p>
                    <p class="text-sm text-gray-500" id="deleteUserUsername"></p>
                </div>
                <p class="text-red-600 text-sm flex items-center gap-2">
                    <i class="bi bi-exclamation-circle"></i>
                    Hành động này không thể hoàn tác!
                </p>
            </div>
            <div class="p-6 border-t border-gray-100 flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Hủy</button>
                <a id="deleteLink" href="#" class="flex-1 py-3 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white font-semibold rounded-xl text-center transition-all">
                    <i class="bi bi-trash mr-2"></i>Xóa
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function openDeleteModal(userId, fullName, username) {
    document.getElementById('deleteUserName').textContent = fullName;
    document.getElementById('deleteUserUsername').textContent = '@' + username;
    document.getElementById('deleteLink').href = '$basePath . '/admin/deleteUser/' + userId;
    document.getElementById('deleteModal').classList.remove('hidden');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>

</body>
</html>
