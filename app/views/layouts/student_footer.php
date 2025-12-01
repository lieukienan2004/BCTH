<?php $basePath = defined('BASE_PATH') ? BASE_PATH : ''; ?>
    <!-- Footer -->
    <footer class="mt-8 py-6 border-t border-gray-200 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <img src="<?= $basePath ?>/images/logoTVU.png" alt="TVU" class="w-8 h-8 object-contain">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Trường Đại học Trà Vinh</p>
                        <p class="text-xs text-gray-500">Khoa Kỹ thuật và Công nghệ</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <a href="#" class="hover:text-blue-600 transition-colors">Hướng dẫn</a>
                    <span>•</span>
                    <a href="#" class="hover:text-blue-600 transition-colors">Liên hệ</a>
                    <span>•</span>
                    <a href="#" class="hover:text-blue-600 transition-colors">Hỗ trợ</a>
                </div>
                <p class="text-xs text-gray-400">© <?= date('Y') ?> TVU Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Sidebar toggle - bấm 3 gạch để ẩn/hiện sidebar
        let sidebarOpen = true; // Mặc định sidebar đang mở
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mainContent = document.querySelector('main');
            
            sidebarOpen = !sidebarOpen;
            
            if (sidebarOpen) {
                // Hiện sidebar
                sidebar.classList.remove('-translate-x-full');
                hamburgerBtn.classList.add('hidden');
                if (mainContent) mainContent.classList.add('lg:ml-72');
            } else {
                // Ẩn sidebar
                sidebar.classList.add('-translate-x-full');
                hamburgerBtn.classList.remove('hidden');
                if (mainContent) mainContent.classList.remove('lg:ml-72');
            }
        }
        
        // User dropdown toggle
        function toggleUserDropdown() {
            const dropdown = document.getElementById('userDropdown');
            const arrow = document.getElementById('dropdownArrow');
            
            if (dropdown) {
                dropdown.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const userBtn = document.getElementById('userBtn');
            const arrow = document.getElementById('dropdownArrow');
            
            if (dropdown && userBtn && !userBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
        
        // Handle avatar fallback
        document.querySelectorAll('img[alt="Avatar"]').forEach(img => {
            img.onerror = function() {
                this.style.display = 'none';
                const fallback = this.parentElement.querySelector('[id*="Fallback"], span');
                if (fallback) fallback.style.display = 'flex';
            };
        });
    </script>
</body>
</html>
