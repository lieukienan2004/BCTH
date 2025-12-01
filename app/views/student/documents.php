<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php $basePath = defined('BASE_PATH') ? BASE_PATH : ''; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');

// Real documents with actual files
$documents = [
    [
        'category' => 'Báo cáo',
        'icon' => 'bi-file-earmark-text',
        'color' => 'blue',
        'items' => [
            ['name' => 'Mẫu báo cáo đồ án', 'desc' => 'Template báo cáo đồ án chuẩn', 'file' => 'mau_bao_cao_do_an.txt', 'type' => 'txt'],
            ['name' => 'Mẫu báo cáo tiến độ tuần', 'desc' => 'Form báo cáo tiến độ hàng tuần', 'file' => 'mau_bao_cao_tien_do.txt', 'type' => 'txt'],
            ['name' => 'Hướng dẫn viết báo cáo', 'desc' => 'Quy định format, font chữ, trình bày', 'file' => 'huong_dan_viet_bao_cao.txt', 'type' => 'txt'],
        ]
    ],
    [
        'category' => 'Slide thuyết trình',
        'icon' => 'bi-file-earmark-slides',
        'color' => 'orange',
        'items' => [
            ['name' => 'Mẫu slide bảo vệ đồ án', 'desc' => 'Cấu trúc slide trình bày', 'file' => 'mau_slide_bao_ve.txt', 'type' => 'txt'],
        ]
    ],
    [
        'category' => 'Biểu mẫu',
        'icon' => 'bi-file-earmark-ruled',
        'color' => 'green',
        'items' => [
            ['name' => 'Đơn xin đổi đề tài', 'desc' => 'Mẫu đơn xin thay đổi đề tài', 'file' => 'don_xin_doi_de_tai.txt', 'type' => 'txt'],
            ['name' => 'Đơn xin gia hạn', 'desc' => 'Mẫu đơn xin gia hạn nộp bài', 'file' => 'don_xin_gia_han.txt', 'type' => 'txt'],
            ['name' => 'Phiếu đánh giá đồ án', 'desc' => 'Tiêu chí chấm điểm đồ án', 'file' => 'phieu_danh_gia_do_an.txt', 'type' => 'txt'],
        ]
    ],
    [
        'category' => 'Tài liệu tham khảo',
        'icon' => 'bi-book',
        'color' => 'purple',
        'items' => [
            ['name' => 'Quy định đồ án CNTT', 'desc' => 'Quy chế thực hiện đồ án tốt nghiệp', 'file' => 'quy_dinh_do_an.txt', 'type' => 'txt'],
        ]
    ]
];
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📁</span><h2 class="text-xl font-bold">Tài liệu mẫu</h2></div>
                <p class="text-white/80 text-sm">Tải xuống các biểu mẫu và tài liệu hướng dẫn</p>
            </div>
            <div class="flex items-center gap-4">
                <a href="<?= $basePath ?>/student/notifications" class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></a>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '$basePath . '/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-teal-400 to-emerald-500 flex items-center justify-center">
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

    <div class="p-8">
        <!-- Search Box -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchDocs" placeholder="Tìm kiếm tài liệu..." 
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:bg-white outline-none transition-all"
                        onkeyup="filterDocs()">
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-files text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= array_sum(array_map(fn($c) => count($c['items']), $documents)) ?></p>
                        <p class="text-xs text-gray-500">Tổng tài liệu</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-download text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">Miễn phí</p>
                        <p class="text-xs text-gray-500">Tải xuống</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-folder text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?= count($documents) ?></p>
                        <p class="text-xs text-gray-500">Danh mục</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-clock-history text-amber-600"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">2024</p>
                        <p class="text-xs text-gray-500">Cập nhật</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Categories -->
        <div class="space-y-6">
            <?php foreach ($documents as $category): 
                $colorClasses = [
                    'blue' => ['bg-blue-500', 'bg-blue-100', 'text-blue-600', 'hover:bg-blue-600'],
                    'orange' => ['bg-orange-500', 'bg-orange-100', 'text-orange-600', 'hover:bg-orange-600'],
                    'green' => ['bg-green-500', 'bg-green-100', 'text-green-600', 'hover:bg-green-600'],
                    'purple' => ['bg-purple-500', 'bg-purple-100', 'text-purple-600', 'hover:bg-purple-600'],
                ];
                $colors = $colorClasses[$category['color']];
            ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden doc-category">
                <div class="<?= $colors[0] ?> px-6 py-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="<?= $category['icon'] ?> text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-white"><?= $category['category'] ?></h2>
                        <p class="text-white/80 text-sm"><?= count($category['items']) ?> tài liệu</p>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($category['items'] as $doc): ?>
                    <div class="doc-item p-4 hover:bg-gray-50 transition-all" data-name="<?= strtolower($doc['name']) ?>">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 <?= $colors[1] ?> rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-file-earmark-text <?= $colors[2] ?> text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-800"><?= $doc['name'] ?></h3>
                                <p class="text-sm text-gray-500"><?= $doc['desc'] ?></p>
                                <p class="text-xs text-gray-400 mt-1">
                                    <i class="bi bi-file-text mr-1"></i><?= strtoupper($doc['type']) ?>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="viewDocument('<?= $doc['file'] ?>', '<?= addslashes($doc['name']) ?>')" 
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all flex items-center gap-2">
                                    <i class="bi bi-eye"></i>
                                    <span class="hidden sm:inline">Xem</span>
                                </button>
                                <a href="<?= $basePath ?>/documents/<?= $doc['file'] ?>" download 
                                    class="px-4 py-2 <?= $colors[0] ?> <?= $colors[3] ?> text-white rounded-lg transition-all flex items-center gap-2 shadow-lg">
                                    <i class="bi bi-download"></i>
                                    <span class="hidden sm:inline">Tải xuống</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl p-6 text-white">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="bi bi-question-circle text-3xl"></i>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h3 class="font-bold text-xl mb-2">Cần hỗ trợ thêm?</h3>
                    <p class="text-white/80">Nếu bạn cần tài liệu khác hoặc có thắc mắc, hãy liên hệ với giảng viên hướng dẫn.</p>
                </div>
                <a href="<?= $basePath ?>/student/contact" class="px-6 py-3 bg-white text-teal-600 font-semibold rounded-xl hover:bg-gray-100 transition-all flex items-center gap-2">
                    <i class="bi bi-chat-dots"></i>
                    Liên hệ ngay
                </a>
            </div>
        </div>
    </div>
</main>

<!-- View Document Modal -->
<div id="viewModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeViewModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-500 px-6 py-4 flex items-center justify-between">
                <h3 id="modalTitle" class="text-white font-bold text-lg"></h3>
                <button onclick="closeViewModal()" class="w-8 h-8 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white transition-all">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-6 max-h-[60vh] overflow-y-auto">
                <pre id="modalContent" class="whitespace-pre-wrap font-mono text-sm text-gray-700 bg-gray-50 p-4 rounded-xl"></pre>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex gap-3">
                <button onclick="closeViewModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">
                    Đóng
                </button>
                <a id="downloadBtn" href="#" download class="flex-1 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white font-semibold rounded-xl text-center transition-all flex items-center justify-center gap-2">
                    <i class="bi bi-download"></i> Tải xuống
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function filterDocs() {
    const search = document.getElementById('searchDocs').value.toLowerCase();
    document.querySelectorAll('.doc-item').forEach(item => {
        const name = item.dataset.name;
        item.style.display = name.includes(search) ? '' : 'none';
    });
    document.querySelectorAll('.doc-category').forEach(cat => {
        const visibleItems = cat.querySelectorAll('.doc-item:not([style*="display: none"])').length;
        cat.style.display = visibleItems > 0 ? '' : 'none';
    });
}

function viewDocument(filename, title) {
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('downloadBtn').href = '$basePath . '/documents/' + filename;
    
    // Fetch and display content
    fetch('$basePath . '/documents/' + filename)
        .then(response => response.text())
        .then(content => {
            document.getElementById('modalContent').textContent = content;
            document.getElementById('viewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        })
        .catch(error => {
            alert('Không thể tải tài liệu. Vui lòng thử lại!');
        });
}

function closeViewModal() {
    document.getElementById('viewModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeViewModal();
});
</script>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
