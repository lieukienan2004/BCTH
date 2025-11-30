<?php include_once __DIR__ . '/../layouts/student_header.php'; ?>
<?php include_once __DIR__ . '/../layouts/student_sidebar_new.php'; ?>

<?php
$daysVi = ['Chủ nhật', 'Thứ hai', 'Thứ ba', 'Thứ tư', 'Thứ năm', 'Thứ sáu', 'Thứ bảy'];
$monthsVi = ['', 'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
$favorites = $_SESSION['favorite_topics'] ?? [];
$userInitial = mb_strtoupper(mb_substr($_SESSION['full_name'] ?? 'U', 0, 1, 'UTF-8'), 'UTF-8');
?>

<main class="lg:ml-72 min-h-screen bg-gray-50">
    <header class="sticky top-0 z-30 bg-gradient-to-r from-cyan-500 via-blue-500 to-blue-600 px-6 py-4 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div class="text-white">
                <div class="flex items-center gap-2 mb-1"><span class="text-xl">📚</span><h2 class="text-xl font-bold">Danh sách đề tài</h2></div>
                <p class="text-white/80 text-sm"><?= $daysVi[date('w')] ?>, <?= date('d') ?> <?= $monthsVi[intval(date('m'))] ?> <?= date('Y') ?></p>
            </div>
            <div class="flex items-center gap-4">
                <a href="/PHP-BCTH/public/student/notifications" class="relative p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-xl"><i class="bi bi-bell text-xl"></i></a>
                <div class="relative pl-4 border-l border-white/20">
                    <?php $avatarPath = '/PHP-BCTH/public/images/avatars/' . ($_SESSION['username'] ?? 'default') . '.jpg'; ?>
                    <button onclick="toggleUserDropdown()" id="userBtn" class="bg-white/20 rounded-full px-4 py-2 flex items-center gap-3 cursor-pointer hover:bg-white/30 transition-all">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-white shadow-lg bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center">
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
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 animate-fade-in">
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

        <!-- Search & Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search Box -->
                <div class="flex-1 relative">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" id="searchInput" placeholder="Tìm kiếm đề tài, giảng viên..." 
                        class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:bg-white outline-none transition-all"
                        onkeyup="filterTopics()">
                </div>
                
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button onclick="setFilter('all')" id="filterAll" class="filter-btn active px-4 py-2 rounded-xl font-medium transition-all bg-blue-500 text-white">
                        <i class="bi bi-grid-3x3-gap mr-1"></i> Tất cả
                    </button>
                    <button onclick="setFilter('available')" id="filterAvailable" class="filter-btn px-4 py-2 rounded-xl font-medium transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="bi bi-check-circle mr-1"></i> Còn slot
                    </button>
                    <button onclick="setFilter('full')" id="filterFull" class="filter-btn px-4 py-2 rounded-xl font-medium transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="bi bi-x-circle mr-1"></i> Đã đủ
                    </button>
                    <button onclick="setFilter('favorites')" id="filterFavorites" class="filter-btn px-4 py-2 rounded-xl font-medium transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                        <i class="bi bi-heart-fill mr-1 text-red-500"></i> Yêu thích
                    </button>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 bg-blue-500 rounded-full"></span>
                    <span class="text-gray-600">Tổng: <strong id="totalCount"><?= count($data['topics'] ?? []) ?></strong> đề tài</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                    <span class="text-gray-600">Còn slot: <strong id="availableCount">0</strong></span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                    <span class="text-gray-600">Yêu thích: <strong id="favoriteCount">0</strong></span>
                </div>
            </div>
        </div>

        <!-- View Toggle -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-800">
                <i class="bi bi-journal-bookmark text-blue-500 mr-2"></i>
                Danh sách đề tài
            </h2>
            <div class="flex gap-2">
                <button onclick="setView('grid')" id="viewGrid" class="p-2 rounded-lg bg-blue-500 text-white">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                </button>
                <button onclick="setView('list')" id="viewList" class="p-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">
                    <i class="bi bi-list-ul"></i>
                </button>
            </div>
        </div>

        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php if (!empty($data['topics'])): ?>
                <?php foreach ($data['topics'] as $index => $topic): 
                    $isFavorite = in_array($topic['topic_id'], $favorites);
                    $isAvailable = $topic['current_students'] < $topic['max_students'] && $topic['status'] === 'approved';
                ?>
                <div class="topic-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                    data-title="<?= strtolower($topic['title']) ?>"
                    data-teacher="<?= strtolower($topic['teacher_name']) ?>"
                    data-available="<?= $isAvailable ? '1' : '0' ?>"
                    data-favorite="<?= $isFavorite ? '1' : '0' ?>"
                    data-id="<?= $topic['topic_id'] ?>">
                    
                    <!-- Card Header -->
                    <div class="relative bg-gradient-to-r <?= $isAvailable ? 'from-blue-500 to-cyan-500' : 'from-gray-400 to-gray-500' ?> p-4">
                        <div class="absolute top-3 right-3 flex gap-2">
                            <button onclick="toggleFavorite(<?= $topic['topic_id'] ?>, this)" 
                                class="favorite-btn w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center hover:bg-white/40 transition-all">
                                <i class="bi <?= $isFavorite ? 'bi-heart-fill text-red-500' : 'bi-heart text-white' ?>"></i>
                            </button>
                        </div>
                        <div class="pr-16">
                            <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-sm rounded-lg text-white text-xs mb-2">
                                #<?= $index + 1 ?>
                            </span>
                            <h3 class="font-bold text-white text-lg line-clamp-2"><?= $topic['title'] ?></h3>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-4">
                        <!-- Teacher Info -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                <?= strtoupper(substr($topic['teacher_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Giảng viên hướng dẫn</p>
                                <p class="font-semibold text-gray-800"><?= $topic['teacher_name'] ?></p>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?= $topic['description'] ?></p>
                        
                        <!-- Stats -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1 px-3 py-1 bg-blue-50 rounded-full">
                                    <i class="bi bi-people text-blue-500"></i>
                                    <span class="text-sm font-medium text-blue-700"><?= $topic['current_students'] ?>/<?= $topic['max_students'] ?></span>
                                </div>
                                <?php if ($topic['status'] === 'approved'): ?>
                                <span class="px-2 py-1 bg-green-50 text-green-600 text-xs font-medium rounded-full">✓ Đã duyệt</span>
                                <?php else: ?>
                                <span class="px-2 py-1 bg-amber-50 text-amber-600 text-xs font-medium rounded-full">⏳ Chờ duyệt</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex gap-2">
                            <button onclick="openDetailModal(<?= htmlspecialchars(json_encode($topic)) ?>)" 
                                class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                                <i class="bi bi-eye"></i> Chi tiết
                            </button>
                            <?php if ($isAvailable): ?>
                            <button onclick="openRegisterModal(<?= $topic['topic_id'] ?>, '<?= addslashes($topic['title']) ?>', '<?= $topic['teacher_name'] ?>')" 
                                class="flex-1 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-medium rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
                                <i class="bi bi-plus-circle"></i> Đăng ký
                            </button>
                            <?php else: ?>
                            <button disabled class="flex-1 py-2.5 bg-gray-300 text-gray-500 font-medium rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                <i class="bi bi-x-circle"></i> Đã đủ
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-span-full py-16 text-center text-gray-400">
                <i class="bi bi-inbox text-6xl mb-4"></i>
                <p class="text-lg">Chưa có đề tài nào</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- List View (Hidden by default) -->
        <div id="listView" class="hidden bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">STT</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Đề tài</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Giảng viên</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Slot</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (!empty($data['topics'])): ?>
                            <?php foreach ($data['topics'] as $index => $topic): 
                                $isFavorite = in_array($topic['topic_id'], $favorites);
                                $isAvailable = $topic['current_students'] < $topic['max_students'] && $topic['status'] === 'approved';
                            ?>
                            <tr class="topic-row hover:bg-blue-50/50 transition-all"
                                data-title="<?= strtolower($topic['title']) ?>"
                                data-teacher="<?= strtolower($topic['teacher_name']) ?>"
                                data-available="<?= $isAvailable ? '1' : '0' ?>"
                                data-favorite="<?= $isFavorite ? '1' : '0' ?>"
                                data-id="<?= $topic['topic_id'] ?>">
                                <td class="px-6 py-4">
                                    <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm"><?= $index + 1 ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <button onclick="toggleFavorite(<?= $topic['topic_id'] ?>, this)" class="mt-1 text-lg">
                                            <i class="bi <?= $isFavorite ? 'bi-heart-fill text-red-500' : 'bi-heart text-gray-300 hover:text-red-400' ?> transition-colors"></i>
                                        </button>
                                        <div>
                                            <p class="font-semibold text-gray-800"><?= $topic['title'] ?></p>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-1"><?= $topic['description'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            <?= strtoupper(substr($topic['teacher_name'], 0, 1)) ?>
                                        </div>
                                        <span class="text-gray-700"><?= $topic['teacher_name'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center gap-1 px-3 py-1.5 <?= $isAvailable ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> rounded-full font-medium text-sm">
                                        <i class="bi bi-people-fill"></i>
                                        <?= $topic['current_students'] ?>/<?= $topic['max_students'] ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if ($topic['status'] === 'approved'): ?>
                                    <span class="px-3 py-1.5 bg-green-100 text-green-700 text-sm font-medium rounded-full inline-flex items-center gap-1">
                                        <i class="bi bi-check-circle-fill"></i> Đã duyệt
                                    </span>
                                    <?php else: ?>
                                    <span class="px-3 py-1.5 bg-amber-100 text-amber-700 text-sm font-medium rounded-full inline-flex items-center gap-1">
                                        <i class="bi bi-clock-fill"></i> Chờ duyệt
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button onclick="openDetailModal(<?= htmlspecialchars(json_encode($topic)) ?>)" class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg transition-all" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <?php if ($isAvailable): ?>
                                        <button onclick="openRegisterModal(<?= $topic['topic_id'] ?>, '<?= addslashes($topic['title']) ?>', '<?= $topic['teacher_name'] ?>')" class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all" title="Đăng ký">
                                            <i class="bi bi-plus-circle"></i>
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden py-16 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-700 mb-2">Không tìm thấy kết quả</h3>
            <p class="text-gray-500">Thử tìm kiếm với từ khóa khác</p>
        </div>
    </div>
</main>

<!-- Register Modal -->
<div id="registerModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeRegisterModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="bi bi-journal-plus text-white text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Xác nhận đăng ký</h3>
            </div>
            <div class="p-6">
                <div class="bg-blue-50 rounded-xl p-4 mb-4">
                    <p class="text-sm text-gray-500 mb-1">Đề tài:</p>
                    <p id="modalTopicTitle" class="font-bold text-gray-800"></p>
                </div>
                <div class="bg-purple-50 rounded-xl p-4 mb-6">
                    <p class="text-sm text-gray-500 mb-1">Giảng viên hướng dẫn:</p>
                    <p id="modalTeacherName" class="font-semibold text-gray-800"></p>
                </div>
                <div class="flex gap-3">
                    <button onclick="closeRegisterModal()" class="flex-1 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                        <i class="bi bi-x-lg mr-2"></i>Hủy
                    </button>
                    <form id="registerForm" method="POST" class="flex-1">
                        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                            <i class="bi bi-check-lg mr-2"></i>Xác nhận
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDetailModal()"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 relative">
                <button onclick="closeDetailModal()" class="absolute top-4 right-4 w-8 h-8 bg-white/20 hover:bg-white/40 rounded-full flex items-center justify-center text-white transition-all">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="bi bi-journal-text text-white text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 text-sm">Chi tiết đề tài</p>
                        <h3 id="detailTitle" class="text-xl font-bold text-white"></h3>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4 max-h-[50vh] overflow-y-auto">
                <div class="flex items-center gap-4 p-4 bg-purple-50 rounded-xl">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold" id="detailTeacherAvatar"></div>
                    <div>
                        <p class="text-sm text-gray-500">Giảng viên hướng dẫn</p>
                        <p id="detailTeacher" class="font-semibold text-gray-800"></p>
                        <p id="detailTeacherEmail" class="text-sm text-blue-600"></p>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-2"><i class="bi bi-file-text"></i> Mô tả</p>
                    <p id="detailDesc" class="text-gray-700"></p>
                </div>
                <div class="p-4 bg-amber-50 rounded-xl">
                    <p class="text-sm text-gray-500 mb-2 flex items-center gap-2"><i class="bi bi-list-check"></i> Yêu cầu</p>
                    <p id="detailReq" class="text-gray-700"></p>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1 p-4 bg-blue-50 rounded-xl text-center">
                        <i class="bi bi-people text-blue-500 text-2xl"></i>
                        <p class="text-sm text-gray-500 mt-1">Số lượng</p>
                        <p id="detailCount" class="font-bold text-gray-800"></p>
                    </div>
                    <div class="flex-1 p-4 bg-green-50 rounded-xl text-center">
                        <i class="bi bi-patch-check text-green-500 text-2xl"></i>
                        <p class="text-sm text-gray-500 mt-1">Trạng thái</p>
                        <p id="detailStatus" class="font-bold text-gray-800"></p>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 flex gap-3">
                <button onclick="closeDetailModal()" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all">Đóng</button>
                <button id="detailRegisterBtn" onclick="registerFromDetail()" class="flex-1 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-semibold rounded-xl shadow-lg transition-all">
                    <i class="bi bi-plus-circle mr-2"></i>Đăng ký ngay
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentFilter = 'all';
let currentView = 'grid';
let currentTopic = null;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateCounts();
});

// Filter topics
function filterTopics() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.topic-card');
    const rows = document.querySelectorAll('.topic-row');
    let visibleCount = 0;

    [...cards, ...rows].forEach(item => {
        const title = item.dataset.title;
        const teacher = item.dataset.teacher;
        const isAvailable = item.dataset.available === '1';
        const isFavorite = item.dataset.favorite === '1';
        
        let matchSearch = title.includes(searchTerm) || teacher.includes(searchTerm);
        let matchFilter = true;
        
        if (currentFilter === 'available') matchFilter = isAvailable;
        else if (currentFilter === 'full') matchFilter = !isAvailable;
        else if (currentFilter === 'favorites') matchFilter = isFavorite;
        
        if (matchSearch && matchFilter) {
            item.style.display = '';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });

    document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
    document.getElementById('gridView').classList.toggle('hidden', visibleCount === 0 || currentView !== 'grid');
    document.getElementById('listView').classList.toggle('hidden', visibleCount === 0 || currentView !== 'list');
}

// Set filter
function setFilter(filter) {
    currentFilter = filter;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-600');
    });
    document.getElementById('filter' + filter.charAt(0).toUpperCase() + filter.slice(1)).classList.remove('bg-gray-100', 'text-gray-600');
    document.getElementById('filter' + filter.charAt(0).toUpperCase() + filter.slice(1)).classList.add('bg-blue-500', 'text-white');
    filterTopics();
}

// Set view
function setView(view) {
    currentView = view;
    document.getElementById('viewGrid').classList.toggle('bg-blue-500', view === 'grid');
    document.getElementById('viewGrid').classList.toggle('text-white', view === 'grid');
    document.getElementById('viewGrid').classList.toggle('bg-gray-100', view !== 'grid');
    document.getElementById('viewList').classList.toggle('bg-blue-500', view === 'list');
    document.getElementById('viewList').classList.toggle('text-white', view === 'list');
    document.getElementById('viewList').classList.toggle('bg-gray-100', view !== 'list');
    document.getElementById('gridView').classList.toggle('hidden', view !== 'grid');
    document.getElementById('listView').classList.toggle('hidden', view !== 'list');
}

// Update counts
function updateCounts() {
    const cards = document.querySelectorAll('.topic-card');
    let available = 0, favorites = 0;
    cards.forEach(card => {
        if (card.dataset.available === '1') available++;
        if (card.dataset.favorite === '1') favorites++;
    });
    document.getElementById('availableCount').textContent = available;
    document.getElementById('favoriteCount').textContent = favorites;
}

// Toggle favorite
function toggleFavorite(topicId, btn) {
    const card = document.querySelector(`.topic-card[data-id="${topicId}"]`);
    const row = document.querySelector(`.topic-row[data-id="${topicId}"]`);
    const isFavorite = card ? card.dataset.favorite === '1' : row.dataset.favorite === '1';
    
    // Toggle state
    if (card) card.dataset.favorite = isFavorite ? '0' : '1';
    if (row) row.dataset.favorite = isFavorite ? '0' : '1';
    
    // Update icons
    document.querySelectorAll(`[data-id="${topicId}"] .favorite-btn i, [data-id="${topicId}"] button i.bi-heart, [data-id="${topicId}"] button i.bi-heart-fill`).forEach(icon => {
        icon.classList.toggle('bi-heart', isFavorite);
        icon.classList.toggle('bi-heart-fill', !isFavorite);
        icon.classList.toggle('text-red-500', !isFavorite);
        icon.classList.toggle('text-white', isFavorite && icon.closest('.favorite-btn'));
    });
    
    // Save to session via AJAX
    fetch('/PHP-BCTH/public/student/toggleFavorite/' + topicId, { method: 'POST' });
    
    updateCounts();
    if (currentFilter === 'favorites') filterTopics();
}

// Modal functions
function openRegisterModal(topicId, title, teacher) {
    document.getElementById('modalTopicTitle').textContent = title;
    document.getElementById('modalTeacherName').textContent = teacher;
    document.getElementById('registerForm').action = '/PHP-BCTH/public/student/register/' + topicId;
    document.getElementById('registerModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeRegisterModal() {
    document.getElementById('registerModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openDetailModal(topic) {
    currentTopic = topic;
    document.getElementById('detailTitle').textContent = topic.title;
    document.getElementById('detailTeacher').textContent = topic.teacher_name;
    document.getElementById('detailTeacherEmail').textContent = topic.teacher_email || '';
    document.getElementById('detailTeacherAvatar').textContent = topic.teacher_name.charAt(0).toUpperCase();
    document.getElementById('detailDesc').textContent = topic.description;
    document.getElementById('detailReq').textContent = topic.requirements;
    document.getElementById('detailCount').textContent = topic.current_students + '/' + topic.max_students + ' sinh viên';
    document.getElementById('detailStatus').textContent = topic.status === 'approved' ? 'Đã duyệt' : 'Chờ duyệt';
    
    const isAvailable = topic.current_students < topic.max_students && topic.status === 'approved';
    document.getElementById('detailRegisterBtn').style.display = isAvailable ? '' : 'none';
    
    document.getElementById('detailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function registerFromDetail() {
    if (currentTopic) {
        closeDetailModal();
        openRegisterModal(currentTopic.topic_id, currentTopic.title, currentTopic.teacher_name);
    }
}

// Close modals on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeRegisterModal();
        closeDetailModal();
    }
});
</script>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.animate-fade-in { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include_once __DIR__ . '/../layouts/student_footer.php'; ?>
