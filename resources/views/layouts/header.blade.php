<nav class="navbar navbar-expand-lg bg-dark-custom navbar-dark border-bottom border-danger shadow-sm">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand fw-bold fs-3 tech-logo" href="/">
            <i class="bi bi-cpu text-laravel me-2"></i>
            <span class="text-white">Electro</span><span class="text-laravel">Gear</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list text-laravel fs-1"></i>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search Bar -->
            <form class="d-flex mx-lg-4 my-3 my-lg-0 flex-grow-1" style="max-width: 500px;" action="#" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control bg-dark text-light border-danger custom-search-input" placeholder="Tìm kiếm linh kiện..." aria-label="Tìm kiếm">
                    <button class="btn btn-laravel px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Navigation Links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-semibold align-items-lg-center text-nowrap tech-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active text-laravel' : 'text-white custom-hover' }} px-3 mx-1" href="/">Trang Chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products') ? 'active text-laravel' : 'text-white custom-hover' }} px-3 mx-1" href="/products">Sản Phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active text-laravel' : 'text-white custom-hover' }} px-3 mx-1" href="/contact">Liên hệ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active text-laravel' : 'text-white custom-hover' }} px-3 mx-1" href="/about">About</a>
                </li>
                <li class="nav-item dropdown px-2">
                    <a class="nav-link dropdown-toggle text-white custom-hover" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh Mục
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark bg-dark-custom border-danger">
                        @if(isset($globalCategories) && $globalCategories->count() > 0)
                            @foreach($globalCategories as $cat)
                                <li>
                                    <a class="dropdown-item custom-hover tech-font-sm" href="/products?category={{ $cat->id }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li><hr class="dropdown-divider border-danger"></li>
                            <li><a class="dropdown-item custom-hover tech-font-sm text-laravel" href="/products">Tất cả sản phẩm</a></li>
                        @else
                            <li><a class="dropdown-item custom-hover tech-font-sm text-white" href="#">Đang cập nhật...</a></li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                    <a class="nav-link text-white custom-hover position-relative d-inline-block px-3" href="/cart">
                        <i class="bi bi-cart3 fs-5"></i> Giỏ Hàng
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-laravel" style="font-size: 0.65rem;">
                            3
                        </span>
                    </a>
                </li>
                <li class="nav-item ms-lg-4 mt-2 mt-lg-0">
                    <a class="btn btn-outline-danger btn-sm rounded-pill px-4 py-2 tech-font-sm" style="letter-spacing: 0.5px;" href="/login">Đăng Nhập</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .custom-hover {
        position: relative;
        transition: color 0.3s ease;
    }
    .custom-hover:hover {
        color: var(--laravel-red) !important;
    }
    
    /* Animated underline for nav links */
    .nav-link.custom-hover::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 5px;
        left: 50%;
        background-color: var(--laravel-red);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    .nav-link.custom-hover:hover::after {
        width: 60%;
    }

    /* Active state underline */
    .nav-link.active {
        position: relative;
    }
    .nav-link.active::after {
        content: '';
        position: absolute;
        width: 60%;
        height: 2px;
        bottom: 5px;
        left: 50%;
        background-color: var(--laravel-red);
        transform: translateX(-50%);
    }

    .input-group .form-control:focus {
        border-color: var(--laravel-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25);
        background-color: #212529; /* keep it dark when focused */
        color: white;
    }
    /* Fix for dropdown item hover background */
    .dropdown-menu-dark .dropdown-item:hover {
        background-color: var(--laravel-red);
        color: white !important;
    }
    .dropdown-menu-dark .dropdown-item::after {
        display: none; /* No underline for dropdown items */
    }

    /* Fix dropdown caret stacking issue (Hard Fix) */
    .dropdown-toggle {
        display: inline-flex !important;
        align-items: center;
        white-space: nowrap;
    }
    .dropdown-toggle::after {
        vertical-align: middle;
        margin-left: 0.35rem;
    }

    /* Tech-Vibe Typography specific for Header */
    .tech-logo {
        font-family: 'Orbitron', sans-serif;
        letter-spacing: 1px;
    }
    .tech-nav {
        font-size: 0.95rem; /* Reduced font size slightly */
        letter-spacing: 0.5px;
    }
    .tech-font-sm {
        font-size: 0.85rem;
    }
    .custom-search-input {
        font-size: 0.9rem;
    }
</style>
