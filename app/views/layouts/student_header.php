<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'Sinh viên - Quản lý Đồ án' ?> | TVU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                        dark: { 800: '#1e293b', 900: '#0f172a' }
                    }
                }
            }
        }
        
        // Kiểm tra session mỗi 5 phút
        setInterval(function() {
            fetch('/PHP-BCTH/public/auth/checkSession', { method: 'GET' })
                .then(response => response.json())
                .then(data => {
                    if (!data.valid) {
                        alert('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                        window.location.href = '/PHP-BCTH/public/auth/login';
                    }
                })
                .catch(() => {
                    // Nếu lỗi kết nối, có thể session đã hết
                });
        }, 300000); // 5 phút = 300000ms
    </script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: rgba(59, 130, 246, 0.1); transform: translateX(5px); }
        .sidebar-link.active { background: linear-gradient(90deg, rgba(59, 130, 246, 0.2), transparent); border-left: 3px solid #3b82f6; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
        .gradient-text { background: linear-gradient(135deg, #3b82f6, #8b5cf6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        /* Ẩn scrollbar nhưng vẫn scroll được */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="font-inter bg-gray-50">
