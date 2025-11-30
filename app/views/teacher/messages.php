<?php
$teacherInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'G', 0, 1, 'UTF-8'), 'UTF-8');
$messages = $data['messages'] ?? [];
$unreadCount = count(array_filter($messages, fn($m) => !$m['is_read']));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn từ sinh viên | TVU Portal</title>
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

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-violet-500 via-purple-500 to-fuchsia-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xl">💬</span>
                    <h2 class="text-xl font-bold">Tin nhắn từ sinh viên</h2>
                    <?php if ($unreadCount > 0): ?>
                    <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full animate-pulse"><?= $unreadCount ?> mới</span>
                    <?php endif; ?>
                </div>
                <p class="text-white/80 text-sm">Xem và phản hồi tin nhắn từ sinh viên</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/PHP-BCTH/public/teacher/messages" class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl">
                    <i class="bi bi-arrow-clockwise text-xl"></i>
                </a>
            </div>
        </div>
    </header>

    <div class="p-8">
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
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-envelope text-purple-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= count($messages) ?></p>
                        <p class="text-sm text-gray-500">Tổng tin nhắn</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-envelope-exclamation text-red-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= $unreadCount ?></p>
                        <p class="text-sm text-gray-500">Chưa đọc</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <i class="bi bi-envelope-check text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= count($messages) - $unreadCount ?></p>
                        <p class="text-sm text-gray-500">Đã đọc</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="bi bi-inbox text-purple-500"></i>
                    Hộp thư đến
                </h3>
            </div>

            <?php if (empty($messages)): ?>
            <div class="p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i class="bi bi-inbox text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Chưa có tin nhắn</h3>
                <p class="text-gray-500">Khi sinh viên gửi tin nhắn, chúng sẽ xuất hiện ở đây</p>
            </div>
            <?php else: ?>
            <div class="divide-y divide-gray-100">
                <?php foreach ($messages as $msg): ?>
                <div class="p-4 hover:bg-gray-50 transition-all <?= !$msg['is_read'] ? 'bg-purple-50/50' : '' ?>">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            <?= strtoupper(substr($msg['sender_name'] ?? 'S', 0, 1)) ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-gray-800"><?= $msg['sender_name'] ?? 'Sinh viên' ?></span>
                                <?php if (!$msg['is_read']): ?>
                                <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">Mới</span>
                                <?php endif; ?>
                                <span class="text-xs text-gray-400 ml-auto"><?= date('d/m/Y H:i', strtotime($msg['created_at'])) ?></span>
                            </div>
                            <h4 class="font-medium text-gray-700 mb-1"><?= htmlspecialchars($msg['title']) ?></h4>
                            <p class="text-gray-600 text-sm line-clamp-2"><?= nl2br(htmlspecialchars($msg['content'])) ?></p>
                            
                            <div class="flex items-center gap-2 mt-3">
                                <button onclick="openMessageModal(<?= htmlspecialchars(json_encode($msg)) ?>)" 
                                    class="px-3 py-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 text-sm font-medium rounded-lg transition-all">
                                    <i class="bi bi-eye mr-1"></i>Xem chi tiết
                                </button>
                                <button onclick="openReplyModal(<?= $msg['sender_id'] ?>, '<?= addslashes($msg['sender_name'] ?? 'Sinh viên') ?>')" 
                                    class="px-3 py-1.5 bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-medium rounded-lg transition-all">
                                    <i class="bi bi-reply mr-1"></i>Phản hồi
                                </button>
                                <?php if (!$msg['is_read']): ?>
                                <a href="/PHP-BCTH/public/teacher/markMessageRead/<?= $msg['notification_id'] ?>" 
                                    class="px-3 py-1.5 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-all">
                                    <i class="bi bi-check2 mr-1"></i>Đánh dấu đã đọc
                                </a>
                                <?php endif; ?>
                                <a href="/PHP-BCTH/public/teacher/deleteMessage/<?= $msg['notification_id'] ?>" 
                                    onclick="return confirm('Bạn có chắc muốn xóa tin nhắn này?')"
                                    class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-lg transition-all ml-auto">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Message Detail Modal -->
<div id="messageModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeMessageModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-fuchsia-500 p-6 relative">
                <button onclick="closeMessageModal()" class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="bi bi-envelope-open text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 text-sm">Tin nhắn từ</p>
                        <h3 id="modalSenderName" class="text-xl font-bold text-white"></h3>
                    </div>
                </div>
            </div>
            <div class="p-6 max-h-[50vh] overflow-y-auto">
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-1">Tiêu đề</p>
                    <h4 id="modalTitle" class="font-semibold text-gray-800"></h4>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-1">Thời gian</p>
                    <p id="modalTime" class="text-gray-700"></p>
                </div>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-500 mb-2">Nội dung</p>
                    <div id="modalContent" class="text-gray-700 whitespace-pre-wrap"></div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 flex gap-3">
                <button onclick="closeMessageModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Đóng</button>
                <button id="modalReplyBtn" class="flex-1 py-3 bg-gradient-to-r from-purple-500 to-fuchsia-500 hover:from-purple-600 hover:to-fuchsia-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                    <i class="bi bi-reply mr-2"></i>Phản hồi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeReplyModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="bi bi-reply"></i>
                    Phản hồi sinh viên
                </h3>
                <p id="replyToName" class="text-white/80 text-sm mt-1"></p>
            </div>
            <form method="POST" action="/PHP-BCTH/public/teacher/replyMessage" class="p-6 space-y-4">
                <input type="hidden" name="student_id" id="replyStudentId">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all" placeholder="Nhập tiêu đề..." required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nội dung <span class="text-red-500">*</span></label>
                    <textarea name="content" rows="5" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all resize-none" placeholder="Nhập nội dung phản hồi..." required></textarea>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeReplyModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Hủy</button>
                    <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                        <i class="bi bi-send mr-2"></i>Gửi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openMessageModal(msg) {
    document.getElementById('modalSenderName').textContent = msg.sender_name || 'Sinh viên';
    document.getElementById('modalTitle').textContent = msg.title;
    document.getElementById('modalTime').textContent = new Date(msg.created_at).toLocaleString('vi-VN');
    document.getElementById('modalContent').textContent = msg.content;
    document.getElementById('modalReplyBtn').onclick = () => {
        closeMessageModal();
        openReplyModal(msg.sender_id, msg.sender_name);
    };
    document.getElementById('messageModal').classList.remove('hidden');
}

function closeMessageModal() {
    document.getElementById('messageModal').classList.add('hidden');
}

function openReplyModal(studentId, studentName) {
    document.getElementById('replyStudentId').value = studentId;
    document.getElementById('replyToName').textContent = 'Gửi đến: ' + studentName;
    document.getElementById('replyModal').classList.remove('hidden');
}

function closeReplyModal() {
    document.getElementById('replyModal').classList.add('hidden');
}
</script>

</body>
</html>
