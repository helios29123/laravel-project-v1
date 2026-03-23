@extends('layouts.master')

@section('title', 'Sản Phẩm - ElectroGear')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary">
        <h2 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-0">Tất Cả Sản Phẩm</h2>
        @isset($sale_status)
            <span class="badge bg-danger fs-6 heartbeat-animation shadow">🔥 Đang giảm giá!</span>
        @endisset
    </div>

    <!-- Bộ lọc sản phẩm đơn giản -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <select class="form-select bg-dark text-white border-danger shadow-sm">
                <option selected>Lọc theo Danh mục</option>
                <option value="1">Vi Điều Khiển</option>
                <option value="2">Cảm Biến</option>
                <option value="3">Module Mở Rộng</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select bg-dark text-white border-danger shadow-sm">
                <option selected>Sắp xếp theo Giá</option>
                <option value="asc">Giá: Thấp đến Cao</option>
                <option value="desc">Giá: Cao xuống Thấp</option>
            </select>
        </div>
    </div>



    <!-- Grid Sản Phẩm -->
    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @foreach($products as $product)
            <div class="col">
                <div class="card h-100 bg-dark-custom border-danger product-card shadow">
                    <div class="position-relative overflow-hidden product-img-wrapper p-2">
                        <a href="{{ route('product.show', $product->product_id) }}">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/300x300/1f2937/ff2d20?text=ElectroGear' }}" class="card-img-top product-img" alt="{{ $product->name }}">
                        </a>
                        <div class="overlay d-flex justify-content-center align-items-center rounded">
                            <button class="btn btn-laravel rounded-circle me-2 p-2 shadow-lg action-btn" title="Thêm vào giỏ" style="width:45px;height:45px;"><i class="bi bi-cart-plus fs-5"></i></button>
                            <a href="{{ route('product.show', $product->product_id) }}" class="btn btn-outline-light rounded-circle p-2 shadow-lg action-btn" title="Xem chi tiết" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;"><i class="bi bi-eye fs-5"></i></a>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <a href="{{ route('product.show', $product->product_id) }}" class="text-decoration-none">
                            <h5 class="card-title text-white flex-grow-1 header-hover mb-2" style="font-size: 1.1rem; line-height: 1.4;">{{ $product->name }}</h5>
                        </a>
                        <div class="d-flex justify-content-between align-items-end mt-auto">
                            <span class="text-laravel fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            <span class="badge bg-success" style="font-size: 0.70rem;">Còn hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Phân trang -->
    <div class="mt-5 mb-3 d-flex justify-content-center custom-pagination-wrapper">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

    <style>
        /* Product Card & Image Effects */
        .product-card {
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(255, 45, 32, 0.25) !important;
            border-color: var(--laravel-red-dark) !important;
        }
        
        .product-img-wrapper {
            border-radius: 12px 12px 0 0;
        }
        .product-img {
            border-radius: 8px;
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-img {
            transform: scale(1.08); /* Zoom effect */
        }

        .header-hover {
            transition: color 0.2s ease;
            cursor: pointer;
        }
        .product-card:hover .header-hover {
            color: var(--laravel-red) !important;
        }

        /* Hover Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(17, 24, 39, 0.75); /* Dark semi-transparent background */
            opacity: 0;
            transition: opacity 0.3s ease;
            backdrop-filter: blur(2px);
        }
        .product-card:hover .overlay {
            opacity: 1;
        }
        
        /* Action Buttons Animation */
        .action-btn {
            transform: translateY(20px) scale(0.9);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .product-card:hover .action-btn {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        .product-card:hover .action-btn:nth-child(2) {
            transition-delay: 0.1s;
        }

        /* Pagination custom */
        .custom-pagination .page-link {
            transition: all 0.2s ease;
        }
        .custom-pagination .page-link:hover:not(.disabled) {
            background-color: var(--laravel-red);
            color: white !important;
        }
        .custom-pagination .active .page-link {
            box-shadow: 0 0 10px rgba(255, 45, 32, 0.4);
        }

        /* Heartbeat for Sale Badge */
        @keyframes heartbeat {
            0% { transform: scale(1); }
            14% { transform: scale(1.15); }
            28% { transform: scale(1); }
            42% { transform: scale(1.15); }
            70% { transform: scale(1); }
        }
        .heartbeat-animation {
            animation: heartbeat 2s infinite;
        }
    </style>
@endsection
