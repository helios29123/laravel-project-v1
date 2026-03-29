<!-- Admin Sidebar Styling -->
<style>
    .admin-sidebar {
        width: 260px;
        min-height: calc(100vh - 60px); /* Phụ thuộc vào chiều cao Header */
        background-color: var(--darker-bg);
        border-right: 1px solid #1f2937;
        box-shadow: 4px 0 15px rgba(0,0,0,0.5);
        transition: all 0.3s;
        /* Fix sidebar sticky */
        position: sticky;
        top: 0;
        z-index: 1000;
        overflow-y: auto;
    }
    
    .sidebar-menu {
        list-style: none;
        padding-left: 0;
        margin-top: 20px;
    }
    
    .sidebar-item {
        margin-bottom: 2px;
    }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 14px 25px;
        color: var(--text-white);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.95rem;
        border-left: 4px solid transparent;
        transition: all 0.2s ease;
    }
    
    .sidebar-link:hover, .sidebar-link.active {
        background-color: var(--dark-surface);
        color: var(--text-light) !important;
        border-left-color: var(--laravel-red);
    }
    
    .sidebar-icon {
        font-size: 1.25rem;
        margin-right: 15px;
        width: 24px;
        text-align: center;
        color: var(--text-white);
        transition: color 0.2s ease;
    }
    
    .sidebar-link:hover .sidebar-icon, .sidebar-link.active .sidebar-icon {
        color: var(--laravel-red);
        text-shadow: 0 0 10px rgba(255, 45, 32, 0.5); /* Glowing effect */
    }
    
    .sidebar-heading {
        padding: 10px 25px;
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #6b7280;
        font-weight: 900;
        letter-spacing: 1.5px;
        margin-top: 20px;
        margin-bottom: 5px;
    }
    
    /* Custom Scrollbar for Sidebar */
    .admin-sidebar::-webkit-scrollbar { width: 4px; }
    .admin-sidebar::-webkit-scrollbar-track { background: var(--darker-bg); }
    .admin-sidebar::-webkit-scrollbar-thumb { background: #374151; }
    
    /* Nút đăng xuất/về trang chủ */
    .btn-cyber-exit {
        border-radius: 4px;
        letter-spacing: 1px;
    }
</style>

<div class="admin-sidebar d-none d-lg-block pb-5 d-flex flex-column position-relative">
    <!-- Main Menu -->
    <ul class="sidebar-menu">
        <li class="sidebar-heading">Tổng Quan Tình Hình</li>
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 sidebar-icon"></i>
                Bảng Điều Khiển
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link text-muted" onclick="alert('Tính năng Quản lý Doanh thu đang chờ code'); return false;">
                <i class="bi bi-graph-up-arrow sidebar-icon"></i>
                Thống Kê Doanh Thu
            </a>
        </li>

        <li class="sidebar-heading mt-4">Trung Tâm Hàng Hóa</li>
        <li class="sidebar-item">
            <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill sidebar-icon"></i>
                Danh Mục (Categories)
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('products.index') }}" class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                <i class="bi bi-cpu-fill sidebar-icon"></i>
                Sản Phẩm Cốt Lõi
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link text-muted" onclick="alert('Tính năng Quản lý Thuộc tính đang chờ code'); return false;">
                <i class="bi bi-sliders2 sidebar-icon"></i>
                Định Nghĩa Phân Loại
            </a>
        </li>

        <li class="sidebar-heading mt-4">Trung Tâm Kinh Doanh</li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link text-muted" onclick="alert('Tính năng Quản lý Đơn hàng đang chờ code'); return false;">
                <i class="bi bi-cart-check-fill sidebar-icon"></i>
                Quản Lý Đơn Hàng
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link text-muted" onclick="alert('Tính năng Quản lý Khách hàng đang chờ code'); return false;">
                <i class="bi bi-people-fill sidebar-icon"></i>
                Hồ Sơ Điện Tử (Users)
            </a>
        </li>
    </ul>

    <!-- Return to Client App -->
    <div class="mt-5 px-4 w-100 mb-4">
        <hr class="border-secondary opacity-25">
        <a href="{{ url('/') }}" class="btn btn-outline-danger w-100 btn-cyber-exit fw-bold py-2">
            <i class="bi bi-door-open-fill me-2"></i>Thoát Khu Vực Mật
        </a>
    </div>
</div>
