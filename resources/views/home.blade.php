@extends('layouts.master')

@section('title', 'Home - ElectroGear')

@section('content')
    <!-- Banner Section -->
    <div class="p-5 mb-5 bg-dark-custom text-white border-bottom border-danger shadow rounded position-relative" style="background: linear-gradient(135deg, #111827 0%, #1f2937 100%);">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-5 fw-bold text-white mb-3">Chào mừng đến với <span class="text-laravel">ElectroGear</span>!</h1>
                <p class="fs-5 text-white mb-4">Mọi linh kiện, module và cảm biến bạn cần cho đồ án Điện Tử - IoT với mức giá tốt nhất.</p>
                <a href="/products" class="btn btn-laravel btn-lg px-4 rounded-pill shadow-sm">Khám phá ngay <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center">
                <i class="bi bi-cpu text-laravel" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <!-- Sản Phẩm Mới Nhất -->
    @if(isset($newProducts) && $newProducts->count() > 0)
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-0">Sản Phẩm Mới Nhất ✨</h3>
            <a href="/products" class="text-laravel text-decoration-none custom-hover">Xem tất cả <i class="bi bi-chevron-right"></i></a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-3">
            @foreach($newProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sản Phẩm Bán Chạy Nhất -->
    @if(isset($bestSellingProducts) && $bestSellingProducts->count() > 0)
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-0">Bán Chạy Nhất 🔥</h3>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-3">
            @foreach($bestSellingProducts as $product)
                @include('partials.product-card', ['product' => $product, 'badge' => 'Hot'])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sản Phẩm Xem Nhiều Nhất -->
    @if(isset($viewedProducts) && $viewedProducts->count() > 0)
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-0">Đang Được Quan Tâm 👁️</h3>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-3">
            @foreach($viewedProducts as $product)
                @include('partials.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
    @endif

    <!-- Sản Phẩm Theo Danh Mục -->
    @if(isset($categories) && $categories->count() > 0)
        @foreach($categories as $category)
            @if($category->products->count() > 0)
            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-2">
                    <h3 class="text-white fw-bold mb-0"><i class="bi bi-cpu me-2 text-danger"></i>{{ $category->name }}</h3>
                    <a href="/products?category={{ $category->category_id }}" class="text-laravel text-decoration-none custom-hover">Khám phá thêm <i class="bi bi-chevron-right"></i></a>
                </div>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 g-3">
                    @foreach($category->products->take(8) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @endif

    <!-- Include CSS block specific for home and product cards if needed -->
    @section('scripts')
    <style>
        /* Product Card & Image Effects */
        .product-card {
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 400px !important;
        }
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(255, 45, 32, 0.25) !important;
            border-color: var(--laravel-red-dark) !important;
        }
        
        .product-img-wrapper {
            border-radius: 12px 12px 0 0;
            background-color: #1f2937;
            height: 70%;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .product-img {
            border-radius: 8px;
            transition: transform 0.5s ease;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        .product-card .card-body {
            height: 30%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product-card:hover .product-img {
            transform: scale(1.08); /* Zoom effect */
        }

        .header-hover {
            transition: color 0.2s ease;
            cursor: pointer;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            min-height: 40px;
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
    </style>
    @endsection
@endsection
