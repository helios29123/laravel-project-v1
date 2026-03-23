<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ElectroGear - Cửa Hàng Linh Kiện Điện Tử')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts for Tech/Electronic Vibe -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Roboto+Mono:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS cho theme Đỏ (Laravel) - Đen -->
    <style>
        :root {
            /* Laravel Red color */
            --laravel-red: #ff2d20;
            --laravel-red-dark: #cc2419;
            /* Dark background colors */
            --dark-bg: #111827; /* Dark grayish blue */
            --darker-bg: #030712; /* Very dark */
            --dark-surface: #1f2937;
            /* Text colors */
            --text-light: #f3f4f6;
            --text-white: #9ca3af;
        }
        
        body {
            background-color: var(--darker-bg);
            color: var(--text-light);
            font-family: 'Roboto Mono', monospace;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Utilities */
        .text-laravel { color: var(--laravel-red) !important; }
        .bg-laravel { background-color: var(--laravel-red) !important; color: white; }
        .bg-dark-custom { background-color: var(--dark-bg) !important; }
        
        .border-danger { border-color: var(--laravel-red) !important; }
        .btn-outline-danger {
            color: var(--laravel-red);
            border-color: var(--laravel-red);
        }
        .btn-outline-danger:hover {
            background-color: var(--laravel-red);
            color: white;
            border-color: var(--laravel-red);
        }

        .btn-laravel {
            background-color: var(--laravel-red);
            color: white;
            border: none;
        }
        .btn-laravel:hover {
            background-color: var(--laravel-red-dark);
            color: white;
        }

        /* Set base elements */
        .main-content {
            flex: 1;
            /* Adding a subtle glow effect at the top */
            position: relative;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--darker-bg); }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 5px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--laravel-red); }

        /* General Links */
        a { text-decoration: none; color: var(--laravel-red); }
        a:hover { color: var(--laravel-red-dark); }
        
        /* Heading font adjustments */
        h1, h2, h3, h4, h5, h6 { color: white; }
    </style>
</head>
<body>
    <!-- Bao gồm Header -->
    @include('layouts.header')

    <!-- Phần content chính -->
    <main class="main-content container mt-4 mb-5">
        @yield('content')
    </main>

    <!-- Bao gồm Footer -->
    @include('layouts.footer')

    <!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Thêm các file Script custom nếu có bằng yield -->
    @yield('scripts')
</body>
</html>
