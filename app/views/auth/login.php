<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ thống Quản lý Đồ án CNTT | TVU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 25%, #0369a1 50%, #075985 75%, #0c4a6e 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-2">
        
        <!-- Left - Branding -->
        <div class="bg-gradient-to-br from-cyan-600 via-blue-600 to-blue-800 p-10 flex flex-col justify-center items-center text-center relative">

            
            <!-- Logo -->
            <div class="w-36 h-36 bg-white rounded-full p-4 shadow-xl mb-6">
                <img src="/PHP-BCTH/public/images/logoTVU.png" alt="Logo TVU" class="w-full h-full object-contain">
            </div>
            
            <!-- Text -->
            <h1 class="text-2xl font-bold text-white mb-2">TRƯỜNG ĐẠI HỌC TRÀ VINH</h1>
            <p class="text-cyan-200 tracking-widest mb-6">TRA VINH UNIVERSITY</p>
            
            <!-- Divider -->
            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-0.5 bg-amber-400"></div>
                <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                <div class="w-10 h-0.5 bg-amber-400"></div>
            </div>
            
            <!-- System name -->
            <div class="bg-white/10 px-5 py-2 rounded-full mb-3">
                <span class="text-amber-300 font-semibold">
                    <i class="bi bi-mortarboard-fill mr-2"></i>Hệ thống Quản lý Đồ án
                </span>
            </div>
            <p class="text-cyan-200 text-sm">Khoa Kỹ thuật và Công nghệ</p>
            
            <!-- Bottom line -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-400"></div>
        </div>
        
        <!-- Right - Form -->
        <div class="p-10 flex flex-col justify-center">
            <!-- Header -->
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center">
                    <i class="bi bi-shield-lock-fill text-cyan-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Đăng nhập</h2>
                    <p class="text-gray-500 text-sm">Chào mừng bạn trở lại!</p>
                </div>
            </div>
            
            <!-- Error -->
            <?php if (isset($data['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-center gap-3">
                <i class="bi bi-exclamation-triangle-fill text-red-500"></i>
                <p class="text-red-700 text-sm"><?= $data['error'] ?></p>
            </div>
            <?php endif; ?>
            
            <!-- Form -->
            <form method="POST" action="/PHP-BCTH/public/login" class="space-y-5">
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tên đăng nhập</label>
                    <div class="relative">
                        <i class="bi bi-person-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="text" 
                            name="username" 
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all"
                            placeholder="Nhập tên đăng nhập"
                            required 
                            autofocus
                        >
                    </div>
                </div>
                
                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mật khẩu</label>
                    <div class="relative">
                        <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full pl-12 pr-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all"
                            placeholder="Nhập mật khẩu"
                            required
                        >
                    </div>
                </div>
                
                <!-- Remember -->
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" class="w-4 h-4 text-cyan-600 rounded">
                    <span class="text-sm text-gray-600">Ghi nhớ đăng nhập</span>
                </label>
                
                <!-- Button -->
                <button 
                    type="submit" 
                    class="w-full py-4 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
                >
                    <i class="bi bi-box-arrow-in-right"></i>
                    Đăng nhập hệ thống
                </button>
            </form>
            
            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <button onclick="openModal()" class="text-cyan-600 hover:text-cyan-700 text-sm font-medium hover:underline">
                    <i class="bi bi-question-circle mr-1"></i>
                    Quên mật khẩu?
                </button>
                <p class="text-gray-400 text-xs mt-3">© 2024 Trường Đại học Trà Vinh</p>
            </div>
        </div>
    </div>

    <!-- Modal Quên mật khẩu -->
    <div id="forgotModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal()"></div>
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mx-4">
                <!-- Header -->
                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-center relative">
                    <button onclick="closeModal()" class="absolute top-4 right-4 text-white/80 hover:text-white">
                        <i class="bi bi-x-lg text-xl"></i>
                    </button>
                    <div id="modalIcon" class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-key-fill text-white text-3xl"></i>
                    </div>
                    <h3 id="modalTitle" class="text-xl font-bold text-white">Lấy lại mật khẩu</h3>
                    <p id="modalDesc" class="text-cyan-100 text-sm mt-1">Nhập thông tin để khôi phục tài khoản</p>
                    
                    <!-- Steps indicator -->
                    <div class="flex justify-center gap-2 mt-4">
                        <div id="step1Dot" class="w-3 h-3 rounded-full bg-white"></div>
                        <div id="step2Dot" class="w-3 h-3 rounded-full bg-white/40"></div>
                        <div id="step3Dot" class="w-3 h-3 rounded-full bg-white/40"></div>
                    </div>
                </div>
                
                <!-- Step 1: Gửi mã -->
                <div id="step1" class="p-6 space-y-5">
                    <div id="step1Error" class="hidden p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-700 text-sm"></div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-person text-cyan-500 mr-1"></i>Tài khoản
                        </label>
                        <div class="relative">
                            <i class="bi bi-person-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="forgotUsername" class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" placeholder="Nhập tên tài khoản" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-send text-cyan-500 mr-1"></i>Hình thức gửi code
                        </label>
                        <div class="relative">
                            <i class="bi bi-envelope-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <select id="forgotMethod" class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all appearance-none cursor-pointer">
                                <option value="email">Qua Email</option>
                            </select>
                            <i class="bi bi-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-at text-cyan-500 mr-1"></i>Email đã đăng ký
                        </label>
                        <div class="relative">
                            <i class="bi bi-envelope-at-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" id="forgotEmail" class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" placeholder="Nhập email đã đăng ký" required>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal()" class="flex-1 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition-all">Hủy</button>
                        <button type="button" onclick="sendCode()" id="sendCodeBtn" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-send-fill"></i>Gửi mã
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Nhập mã -->
                <div id="step2" class="p-6 space-y-5 hidden">
                    <div id="step2Error" class="hidden p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-700 text-sm"></div>
                    <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-center">
                        <i class="bi bi-check-circle-fill text-green-500 text-2xl"></i>
                        <p class="text-green-700 text-sm mt-2">Mã xác nhận đã được gửi đến email của bạn!</p>
                        <p id="sentEmail" class="text-green-600 font-semibold text-sm"></p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-shield-check text-cyan-500 mr-1"></i>Nhập mã xác nhận (6 số)
                        </label>
                        <div class="flex gap-2 justify-center">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="0">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="1">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="2">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="3">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="4">
                            <input type="text" maxlength="1" class="code-input w-12 h-14 text-center text-2xl font-bold bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" data-index="5">
                        </div>
                    </div>
                    
                    <p class="text-center text-gray-500 text-sm">
                        Chưa nhận được mã? <button type="button" onclick="resendCode()" class="text-cyan-600 hover:underline font-medium">Gửi lại</button>
                    </p>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="goToStep(1)" class="flex-1 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition-all">Quay lại</button>
                        <button type="button" onclick="verifyCode()" id="verifyBtn" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-lg"></i>Xác nhận
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Đổi mật khẩu -->
                <div id="step3" class="p-6 space-y-5 hidden">
                    <div id="step3Error" class="hidden p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-red-700 text-sm"></div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-lock text-cyan-500 mr-1"></i>Mật khẩu mới
                        </label>
                        <div class="relative">
                            <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="newPassword" class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" placeholder="Nhập mật khẩu mới" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="bi bi-lock-fill text-cyan-500 mr-1"></i>Xác nhận mật khẩu
                        </label>
                        <div class="relative">
                            <i class="bi bi-lock-fill absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="confirmPassword" class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:border-cyan-500 focus:bg-white outline-none transition-all" placeholder="Nhập lại mật khẩu mới" required>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="goToStep(2)" class="flex-1 py-3 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition-all">Quay lại</button>
                        <button type="button" onclick="resetPassword()" id="resetBtn" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                            <i class="bi bi-check-circle"></i>Đổi mật khẩu
                        </button>
                    </div>
                </div>
                
                <!-- Success -->
                <div id="stepSuccess" class="p-6 text-center hidden">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-check-circle-fill text-green-500 text-4xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Đổi mật khẩu thành công!</h4>
                    <p class="text-gray-500 mb-6">Bạn có thể đăng nhập với mật khẩu mới.</p>
                    <button onclick="closeModal()" class="w-full py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-xl">
                        Đăng nhập ngay
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let resetToken = '';
        
        function openModal() {
            document.getElementById('forgotModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            goToStep(1);
        }
        
        function closeModal() {
            document.getElementById('forgotModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form
            document.getElementById('forgotUsername').value = '';
            document.getElementById('forgotEmail').value = '';
            document.querySelectorAll('.code-input').forEach(i => i.value = '');
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        }
        
        function goToStep(step) {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.add('hidden');
            document.getElementById('stepSuccess').classList.add('hidden');
            document.getElementById('step' + step).classList.remove('hidden');
            
            // Update dots
            document.getElementById('step1Dot').className = 'w-3 h-3 rounded-full ' + (step >= 1 ? 'bg-white' : 'bg-white/40');
            document.getElementById('step2Dot').className = 'w-3 h-3 rounded-full ' + (step >= 2 ? 'bg-white' : 'bg-white/40');
            document.getElementById('step3Dot').className = 'w-3 h-3 rounded-full ' + (step >= 3 ? 'bg-white' : 'bg-white/40');
            
            // Update header
            const titles = ['', 'Lấy lại mật khẩu', 'Nhập mã xác nhận', 'Đặt mật khẩu mới'];
            const descs = ['', 'Nhập thông tin để khôi phục tài khoản', 'Kiểm tra email và nhập mã 6 số', 'Tạo mật khẩu mới cho tài khoản'];
            const icons = ['', 'bi-key-fill', 'bi-shield-check', 'bi-lock-fill'];
            
            document.getElementById('modalTitle').textContent = titles[step];
            document.getElementById('modalDesc').textContent = descs[step];
            document.getElementById('modalIcon').innerHTML = '<i class="bi ' + icons[step] + ' text-white text-3xl"></i>';
        }
        
        function showError(step, message) {
            const errorDiv = document.getElementById('step' + step + 'Error');
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }
        
        function hideError(step) {
            document.getElementById('step' + step + 'Error').classList.add('hidden');
        }
        
        async function sendCode() {
            const username = document.getElementById('forgotUsername').value;
            const email = document.getElementById('forgotEmail').value;
            const btn = document.getElementById('sendCodeBtn');
            
            if (!username || !email) {
                showError(1, 'Vui lòng nhập đầy đủ thông tin!');
                return;
            }
            
            hideError(1);
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split animate-spin"></i> Đang gửi...';
            
            try {
                const response = await fetch('/PHP-BCTH/public/auth/sendResetCode', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ username, email })
                });
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('sentEmail').textContent = email;
                    goToStep(2);
                    // Tự động điền mã sau 10 giây (chỉ dùng khi test)
                    if (data.debug_code) {
                        startAutoFillCountdown(data.debug_code);
                    }
                } else {
                    showError(1, data.message || 'Có lỗi xảy ra!');
                }
            } catch (e) {
                showError(1, 'Không thể kết nối server!');
            }
            
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send-fill"></i> Gửi mã';
        }
        
        function resendCode() {
            goToStep(1);
            sendCode();
        }
        
        async function verifyCode() {
            const inputs = document.querySelectorAll('.code-input');
            let code = '';
            inputs.forEach(i => code += i.value);
            
            if (code.length !== 6) {
                showError(2, 'Vui lòng nhập đủ 6 số!');
                return;
            }
            
            hideError(2);
            const btn = document.getElementById('verifyBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang xác nhận...';
            
            try {
                const response = await fetch('/PHP-BCTH/public/auth/verifyResetCode', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        username: document.getElementById('forgotUsername').value,
                        code 
                    })
                });
                const data = await response.json();
                
                if (data.success) {
                    resetToken = data.token;
                    goToStep(3);
                } else {
                    showError(2, data.message || 'Mã không đúng!');
                }
            } catch (e) {
                showError(2, 'Không thể kết nối server!');
            }
            
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Xác nhận';
        }
        
        async function resetPassword() {
            const newPass = document.getElementById('newPassword').value;
            const confirmPass = document.getElementById('confirmPassword').value;
            
            if (newPass.length < 6) {
                showError(3, 'Mật khẩu phải có ít nhất 6 ký tự!');
                return;
            }
            if (newPass !== confirmPass) {
                showError(3, 'Mật khẩu xác nhận không khớp!');
                return;
            }
            
            hideError(3);
            const btn = document.getElementById('resetBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Đang xử lý...';
            
            try {
                const response = await fetch('/PHP-BCTH/public/auth/resetPassword', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ 
                        username: document.getElementById('forgotUsername').value,
                        token: resetToken,
                        password: newPass 
                    })
                });
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('step3').classList.add('hidden');
                    document.getElementById('stepSuccess').classList.remove('hidden');
                } else {
                    showError(3, data.message || 'Có lỗi xảy ra!');
                }
            } catch (e) {
                showError(3, 'Không thể kết nối server!');
            }
            
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-check-circle"></i> Đổi mật khẩu';
        }
        
        // Auto focus next input for code
        document.querySelectorAll('.code-input').forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value && index < 5) {
                    document.querySelectorAll('.code-input')[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    document.querySelectorAll('.code-input')[index - 1].focus();
                }
            });
        });
        
        // Tự động điền mã sau 10 giây (chỉ dùng khi test)
        let countdownTimer = null;
        let savedCode = '';
        
        function startAutoFillCountdown(code) {
            savedCode = code;
            let seconds = 10;
            
            // Thêm thông báo countdown
            const countdownDiv = document.createElement('div');
            countdownDiv.id = 'autoFillCountdown';
            countdownDiv.className = 'p-3 bg-blue-50 border border-blue-200 rounded-xl text-center mt-4';
            countdownDiv.innerHTML = `
                <p class="text-blue-700 text-sm">
                    <i class="bi bi-clock"></i> Tự động điền mã sau <span id="countdownSeconds" class="font-bold">${seconds}</span> giây
                </p>
                <button onclick="autoFillCode()" class="mt-2 px-4 py-1 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                    Điền ngay
                </button>
            `;
            
            const step2Error = document.getElementById('step2Error');
            step2Error.parentNode.insertBefore(countdownDiv, step2Error.nextSibling);
            
            countdownTimer = setInterval(() => {
                seconds--;
                const countdownEl = document.getElementById('countdownSeconds');
                if (countdownEl) {
                    countdownEl.textContent = seconds;
                }
                
                if (seconds <= 0) {
                    clearInterval(countdownTimer);
                    autoFillCode();
                }
            }, 1000);
        }
        
        function autoFillCode() {
            if (countdownTimer) {
                clearInterval(countdownTimer);
            }
            
            // Xóa countdown div
            const countdownDiv = document.getElementById('autoFillCountdown');
            if (countdownDiv) {
                countdownDiv.remove();
            }
            
            // Điền mã vào các ô
            const inputs = document.querySelectorAll('.code-input');
            const codeArray = savedCode.split('');
            
            inputs.forEach((input, index) => {
                if (codeArray[index]) {
                    input.value = codeArray[index];
                    input.classList.add('border-green-500', 'bg-green-50');
                }
            });
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>
