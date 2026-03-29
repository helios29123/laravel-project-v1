@extends('layouts.master')

@section('title', 'Admin Dashboard - ElectroGear')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="text-white fw-bold"><i class="bi bi-speedometer2 me-2 text-laravel"></i>Bảng Điểu Khiển (Dashboard)</h4>
        <p class="text-secondary">Tổng quan hoạt động kinh doanh của ElectroGear</p>
    </div>
</div>

<!-- Thẻ Tóm tắt (Summary Cards) -->
<div class="row g-4 mb-4">
    <!-- Doanh Thu Đã Fix Cứng -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark-custom border-secondary h-100 shadow-sm metric-card">
            <div class="card-body p-4 text-center">
                <div class="metric-icon bg-laravel-soft text-laravel mb-3 mx-auto">
                    <i class="bi bi-currency-dollar fs-3"></i>
                </div>
                <h6 class="text-secondary fw-bold text-uppercase mb-2">Tổng Doanh Thu</h6>
                <h3 class="text-white fw-bold mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}₫</h3>
                <small class="text-success mt-2 d-block"><i class="bi bi-arrow-up-right me-1"></i>+12.5% so với tháng trước</small>
            </div>
        </div>
    </div>

    <!-- Đơn Hàng (Đang chờ) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark-custom border-secondary h-100 shadow-sm metric-card">
            <div class="card-body p-4 text-center">
                <div class="metric-icon bg-warning-soft text-warning mb-3 mx-auto">
                    <i class="bi bi-cart-check fs-3"></i>
                </div>
                <h6 class="text-secondary fw-bold text-uppercase mb-2">Đơn Hàng (tháng)</h6>
                <h3 class="text-white fw-bold mb-0">{{ $ordersCount }}</h3>
                <small class="text-warning mt-2 d-block">Đang xử lý 20 đơn</small>
            </div>
        </div>
    </div>

    <!-- Sản Phẩm (Động) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark-custom border-secondary h-100 shadow-sm metric-card">
            <div class="card-body p-4 text-center">
                <div class="metric-icon bg-info-soft text-info mb-3 mx-auto">
                    <i class="bi bi-box-seam fs-3"></i>
                </div>
                <h6 class="text-secondary fw-bold text-uppercase mb-2">Tổng Sản Phẩm</h6>
                <h3 class="text-white fw-bold mb-0">{{ $productsCount }}</h3>
                <small class="text-secondary mt-2 d-block">Phân bổ trong {{ $categoriesCount }} danh mục</small>
            </div>
        </div>
    </div>

    <!-- Khách Hàng (Động) -->
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark-custom border-secondary h-100 shadow-sm metric-card">
            <div class="card-body p-4 text-center">
                <div class="metric-icon bg-primary-soft text-primary mb-3 mx-auto">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <h6 class="text-secondary fw-bold text-uppercase mb-2">Người Dùng</h6>
                <h3 class="text-white fw-bold mb-0">{{ $usersCount }}</h3>
                <small class="text-success mt-2 d-block">Tài khoản đang hoạt động tốt</small>
            </div>
        </div>
    </div>
</div>

<!-- Biểu Đồ (Charts) -->
<div class="row g-4">
    <!-- Chart Doanh Thu -->
    <div class="col-lg-8">
        <div class="card bg-dark-custom border-secondary shadow-sm h-100">
            <div class="card-header border-secondary bg-transparent py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-white fw-bold">Biểu đồ doanh thu 6 tháng gần nhất</h6>
                <div class="badge bg-secondary">Cập nhật tĩnh</div>
            </div>
            <div class="card-body p-4">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Tỉ lệ Đơn Hàng -->
    <div class="col-lg-4">
        <div class="card bg-dark-custom border-secondary shadow-sm h-100">
            <div class="card-header border-secondary bg-transparent py-3">
                <h6 class="mb-0 text-white fw-bold">Tỉ lệ Trạng thái Đơn hàng</h6>
            </div>
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                <div style="width: 250px; height: 250px;">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Nhúng thư viện Chart.js bằng CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* CSS trang trí các Metric Cards */
    .metric-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
    }
    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4) !important;
        border-color: var(--laravel-red) !important;
    }
    .metric-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* Soft color backgrounds for icons */
    .bg-laravel-soft { background-color: rgba(255, 45, 32, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy dữ liệu từ Laravel Controller dạng Tĩnh/Dynamic
        const revLabels = {!! json_encode($revenueChartData['labels']) !!};
        const revData = {!! json_encode($revenueChartData['data']) !!};
        
        const ordLabels = {!! json_encode($orderStatusChartData['labels']) !!};
        const ordData = {!! json_encode($orderStatusChartData['data']) !!};

        // Cấu hình định dạng Dark Theme mặc định cho Chart.js để mượt mắt
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = '#374151';

        // 1. Dựng Biểu đồ Doanh Thu (Bar Chart - Hình Cột)
        const ctxRev = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctxRev, {
            type: 'bar',
            data: {
                labels: revLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: revData,
                    backgroundColor: 'rgba(255, 45, 32, 0.8)', // Laravel Red chủ đạo
                    borderColor: '#ff2d20',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false } // Ẩn legend cột do chỉ có 1 data set
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                }
            }
        });

        // 2. Dựng Biểu đồ Trạng thái Đơn (Doughnut Chart - Hình Tròn Khuyết)
        const ctxOrd = document.getElementById('orderChart').getContext('2d');
        new Chart(ctxOrd, {
            type: 'doughnut',
            data: {
                labels: ordLabels,
                datasets: [{
                    data: ordData,
                    backgroundColor: [
                        '#10b981', // green (Hoàn thành)
                        '#f59e0b', // yellow (Đang giao)
                        '#ef4444'  // red (Hủy)
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 20, color: '#f3f4f6' }
                    }
                }
            }
        });
    });
</script>
@endsection
