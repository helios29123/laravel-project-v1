@extends('layouts.master')

@section('title', $product->name . ' - ElectroGear')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb bg-dark-custom p-3 rounded border-bottom border-secondary shadow-sm">
        <li class="breadcrumb-item"><a href="/" class="text-laravel text-decoration-none hover-light">Trang Chủ</a></li>
        <li class="breadcrumb-item"><a href="/products" class="text-laravel text-decoration-none hover-light">Sản Phẩm</a></li>
        <li class="breadcrumb-item active text-white" aria-current="page">{{ strlen($product->name) > 30 ? substr($product->name, 0, 30) . '...' : $product->name }}</li>
    </ol>
</nav>

<div class="row mb-5">
    <!-- Hình ảnh sản phẩm -->
    <div class="col-lg-5 mb-4 mb-lg-0">
        <div class="bg-white p-3 rounded shadow d-flex justify-content-center align-items-center" style="height: 400px; border: 1px solid #374151;">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/600x600/1f2937/ff2d20?text=ElectroGear' }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 100%; object-fit: contain;">
        </div>
        <div class="row mt-3 g-2 d-none d-md-flex">
            <!-- Thumbnail giả lập -->
            <div class="col-3">
                <div class="bg-white p-1 rounded border border-danger shadow-sm" style="cursor: pointer; height: 80px;">
                    <img src="{{ $product->image ?? 'https://via.placeholder.com/150x150/1f2937/ff2d20' }}" class="img-fluid rounded w-100 h-100" style="object-fit: contain;" alt="Thumb 1">
                </div>
            </div>
            <div class="col-3">
                <div class="bg-white p-1 rounded border border-secondary shadow-sm opacity-75 hover-opacity-100" style="cursor: pointer; height: 80px;">
                    <img src="https://via.placeholder.com/150x150/1f2937/cccccc?text=Goc+Khac" class="img-fluid rounded w-100 h-100" style="object-fit: contain;" alt="Thumb 2">
                </div>
            </div>
            <div class="col-3">
                <div class="bg-white p-1 rounded border border-secondary shadow-sm opacity-75 hover-opacity-100" style="cursor: pointer; height: 80px;">
                    <img src="https://via.placeholder.com/150x150/1f2937/cccccc?text=Mat+Sau" class="img-fluid rounded w-100 h-100" style="object-fit: contain;" alt="Thumb 3">
                </div>
            </div>
            <div class="col-3">
                <div class="bg-white p-1 rounded border border-secondary shadow-sm opacity-75 hover-opacity-100" style="cursor: pointer; height: 80px;">
                     <img src="https://via.placeholder.com/150x150/1f2937/cccccc?text=Hop" class="img-fluid rounded w-100 h-100" style="object-fit: contain;" alt="Thumb 4">
                </div>
            </div>
        </div>
    </div>

    <!-- Thông tin chi tiết sản phẩm -->
    <div class="col-lg-7">
        <div class="bg-dark-custom p-4 rounded shadow h-100 border-bottom border-danger">
            <h2 class="text-white fw-bold mb-3">{{ $product->name }}</h2>
            
            <div class="d-flex flex-wrap align-items-center mb-3">
                <div class="text-warning me-3" style="font-size: 1.1rem;">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <a href="#reviews" class="text-white ms-1 text-decoration-none hover-light">(24 Đánh giá)</a>
                </div>
                <div class="text-white border-start border-secondary ps-3 me-3 d-flex align-items-center">
                    <i class="bi bi-eye text-laravel me-1"></i> Lượt xem: <strong class="text-white ms-1">{{ number_format($product->view_count ?? rand(100,500), 0, ',', '.') }}</strong>
                </div>
                <div class="text-white border-start border-secondary ps-3 d-flex align-items-center">
                    <i class="bi bi-cart-check text-success me-1"></i> Đã bán: <strong class="text-white ms-1">{{ number_format($product->sold_count ?? rand(10,100), 0, ',', '.') }}</strong>
                </div>
            </div>

            <div class="bg-dark p-3 rounded mb-4 border border-secondary">
                <div class="d-flex align-items-center">
                    <h2 class="text-laravel fw-bold mb-0 me-3" id="product-price">
                        @if($product->variants->count() > 0)
                            {{ number_format($product->variants->first()->price, 0, ',', '.') }}₫
                        @else
                            Liên hệ
                        @endif
                    </h2>
                    @if(isset($product->old_price) || ($product->variants->count() > 0 && $product->variants->first()->price < 150000))
                        <span class="text-white text-decoration-line-through fs-5 me-2">{{ number_format(($product->variants->count() > 0 ? $product->variants->first()->price : 0) * 1.2, 0, ',', '.') }}₫</span>
                        <span class="badge bg-danger">-20%</span>
                    @endif
                </div>
            </div>

            <div class="mb-4 text-white" style="line-height: 1.7;">
                <p>Khám phá sản phẩm <span class="text-white fw-bold">{{ $product->name }}</span> chất lượng cao, linh kiện gốc đảm bảo sự bền bỉ cho các dự án và đồ án IoT của bạn. Cảm biến hoạt động ổn định, độ trễ thấp và độ tương thích rộng rãi với các board mạch Arduino, Raspberry, ESP.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check2-circle text-laravel me-2"></i> Tình trạng: <span class="badge bg-success ms-1">Mới 100% Nguyên hộp</span></li>
                    <li class="mt-2"><i class="bi bi-check2-circle text-laravel me-2"></i> Bảo hành: <span class="text-white">6 Tháng 1 Đổi 1</span></li>
                    <li class="mt-2"><i class="bi bi-check2-circle text-laravel me-2"></i> Giao hàng: <span class="text-white">Hỏa tốc nội thành 2h</span></li>
                </ul>
            </div>

            <hr class="border-secondary">

            <div class="d-flex align-items-center gap-3 mt-4 mb-4">
                <div class="input-group" style="width: 140px;">
                    <button class="btn btn-outline-secondary text-white" type="button" onclick="decreaseQty()"><i class="bi bi-dash"></i></button>
                    <input type="text" id="qtyInput" class="form-control text-center bg-dark text-white border-secondary" value="1">
                    <button class="btn btn-outline-secondary text-white" type="button" onclick="increaseQty()"><i class="bi bi-plus"></i></button>
                </div>
                <div class="text-white small" id="stock-info">
                    @if($product->variants->count() > 0)
                        Kho: {{ $product->variants->first()->stock_quantity }} sản phẩm
                    @else
                        Hết hàng
                    @endif
                </div>
            </div>

            @if($product->variants->count() > 1)
            <div class="mb-4">
                <label class="form-label text-white fw-bold">Chọn phiên bản:</label>
                <div class="d-flex flex-wrap gap-2" id="variant-selector">
                    @foreach($product->variants as $variant)
                    <button class="btn btn-outline-secondary variant-btn {{ $loop->first ? 'active' : '' }}"
                            type="button"
                            data-variant-id="{{ $variant->product_variant_id }}"
                            data-price="{{ $variant->price }}"
                            data-stock="{{ $variant->stock_quantity }}"
                            data-sku="{{ $variant->sku }}">
                        {{ $variant->sku }} - {{ number_format($variant->price, 0, ',', '.') }}₫
                    </button>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="d-flex gap-2">
                <button class="btn btn-outline-laravel btn-lg px-4 flex-grow-1 shadow-sm d-flex align-items-center justify-content-center"
                        id="add-to-cart-btn"
                        title="Thêm vào giỏ hàng"
                        @if($product->variants->count() == 0) disabled @endif>
                    <i class="bi bi-cart-plus me-2 fs-5"></i> THÊM VÀO GIỎ
                </button>
                <a href="/checkout" class="btn btn-laravel btn-lg px-4 flex-grow-1 shadow d-flex align-items-center justify-content-center text-decoration-none">
                    MUA MUA NGAY <i class="bi bi-arrow-right ms-2 fs-5"></i>
                </a>
            </div>
            
            <div class="mt-4 border border-secondary rounded p-3 bg-dark">
                <div class="d-flex align-items-center gap-4 text-white small">
                    <div class="text-center"><i class="bi bi-shield-check fs-4 text-success mb-1 d-block"></i>Hàng chính hãng</div>
                    <div class="text-center"><i class="bi bi-arrow-return-left fs-4 text-primary mb-1 d-block"></i>Đổi trả 7 ngày</div>
                    <div class="text-center"><i class="bi bi-truck fs-4 text-warning mb-1 d-block"></i>Giao hàng toàn quốc</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabs Thông tin và Đánh giá -->
<div class="row mb-5">
    <div class="col-12">
        <ul class="nav nav-tabs custom-tabs border-bottom border-danger" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active bg-dark-custom text-white border-secondary border-bottom-0 rounded-top" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab" aria-controls="desc" aria-selected="true">
                    Mô Tả Sản Phẩm
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link bg-transparent text-white border-0" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                    Đánh Giá Khách Hàng (24)
                </button>
            </li>
        </ul>
        <div class="tab-content bg-dark-custom p-4 border border-top-0 border-secondary rounded-bottom shadow" id="productTabsContent">
            <!-- Mô tả chi tiết -->
            <div class="tab-pane fade show active text-white" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                <h4 class="fw-bold mb-4 text-laravel border-start border-danger border-4 ps-3">Chi Tiết {{ $product->name }}</h4>
                <div class="text-white" style="line-height: 1.8;">
                    <p>Sản phẩm <strong>{{ $product->name }}</strong> là một thành phần không thể thiếu trong các bộ kit học tập và ứng dụng thực tế về Điện tử - Viễn thông và IoT. Được thiết kế với kích thước nhỏ gọn nhưng mang lại độ tin cậy và độ bền cao, sản phẩm cho phép người dùng dễ dàng giao tiếp qua các chuẩn thông dụng.</p>
                    <p>Đặc điểm nổi bật:</p>
                    <ul>
                        <li><strong class="text-white">Loại linh kiện:</strong> Module / Board mở rộng</li>
                        <li><strong class="text-white">Điện áp hoạt động:</strong> Tương thích linh hoạt (thường 3.3V hoặc 5V)</li>
                        <li><strong class="text-white">Kiểu kết nối:</strong> Chuẩn DIP cắm trực tiếp được trên Breadboard hoặc Header pin.</li>
                        <li><strong class="text-white">Ứng dụng:</strong> Nhà thông minh, đo lường môi trường, robot tự hành,...</li>
                    </ul>
                    <p class="mt-4">Lưu ý khi sử dụng: Tránh cấp nguồn ngược cực để không làm cháy chip IC trên board. Để đạt hiệu năng cao nhất, vui lòng sử dụng nguồn DC ổn áp hoặc cấp qua cổng phân nguồn tiêu chuẩn của Arduino/NodeMCU.</p>
                </div>
            </div>
            
            <!-- Đánh giá -->
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0 text-center border-end border-secondary">
                        <h1 class="display-3 fw-bold text-white mb-0">4.8</h1>
                        <div class="text-warning fs-4 mb-2">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                        <p class="text-white">Tổng số 24 đánh giá</p>
                        <button class="btn btn-outline-laravel mt-3">Viết đánh giá của bạn</button>
                    </div>
                    <div class="col-lg-8 ps-lg-4">
                        <!-- Comment 1 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 50px; height: 50px;">H</div>
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Hoàng Tuấn <span class="ms-2 text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></span></h6>
                                <p class="text-white small mb-2">12/03/2026 10:45</p>
                                <p class="text-light mb-0">Hàng giao rất nhanh, đóng gói cẩn thận. Test thử với Arduino Uno R3 chạy rất mượt, số liệu trả về ổn định. Vote 5 sao cho shop.</p>
                            </div>
                        </div>
                        <hr class="border-secondary mb-4">
                        <!-- Comment 2 -->
                        <div class="d-flex mb-4">
                            <div class="me-3">
                                <img src="https://ui-avatars.com/api/?name=L+D&background=random" class="rounded-circle" width="50" height="50" alt="Avatar">
                            </div>
                            <div>
                                <h6 class="text-white mb-1">Lê Đức <span class="ms-2 text-warning small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i></span></h6>
                                <p class="text-white small mb-2">10/03/2026 15:20</p>
                                <p class="text-light mb-0">Sản phẩm đẹp, hàn chân header rất chắc chắn, board mạch sạch sẽ. Có điều thư viện đi kèm lấy trên mạng hơi cũ tí xíu tự fix lại xài ngon lành.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gợi ý Sản phẩm -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-secondary">
        <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-0">Sản Phẩm Cùng Danh Mục 💡</h3>
    </div>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
        @foreach($relatedProducts as $item)
            @include('partials.product-card', ['product' => $item])
        @endforeach
    </div>
</div>
@endif

@section('scripts')
<style>
    .hover-light:hover { color: white !important; transition: color 0.2s;}
    .hover-opacity-100 { transition: opacity 0.3s ease; }
    .hover-opacity-100:hover { opacity: 1 !important; border-color: var(--laravel-red) !important;}
    
    .btn-outline-laravel {
        color: var(--laravel-red);
        border-color: var(--laravel-red);
    }
    .btn-outline-laravel:hover {
        background-color: var(--laravel-red);
        color: white;
    }
    
    /* Tabs custom css */
    .custom-tabs .nav-link { font-weight: 500; font-size: 1.1rem; padding: 12px 24px; transition: all 0.3s; }
    .custom-tabs .nav-link.active {
        background-color: var(--dark-custom) !important;
        border-color: var(--laravel-red) var(--laravel-red) transparent var(--laravel-red) !important;
        color: var(--laravel-red) !important;
    }
    .custom-tabs .nav-link:not(.active):hover {
        color: var(--laravel-red) !important;
    }
    
    /* Support existing product card on detail page */
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
    .overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(17, 24, 39, 0.75); opacity: 0; transition: opacity 0.3s;
        backdrop-filter: blur(2px);
    }
    .product-card:hover .overlay { opacity: 1; }
    .action-btn { transform: translateY(20px) scale(0.9); opacity: 0; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    .product-card:hover .action-btn { transform: translateY(0) scale(1); opacity: 1; }
    .header-hover { transition: color 0.2s ease; cursor: pointer; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; }
    .product-card:hover .header-hover { color: var(--laravel-red) !important; }
</style>
<script>
    function increaseQty() {
        let input = document.getElementById('qtyInput');
        input.value = parseInt(input.value) + 1;
    }
    function decreaseQty() {
        let input = document.getElementById('qtyInput');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        // Simple tab switching logic without relying purely on bootstrap js if it's missing
        let descTab = document.getElementById('desc-tab');
        let reviewTab = document.getElementById('reviews-tab');
        
        if (descTab && reviewTab) {
            descTab.addEventListener('click', function() {
                descTab.classList.add('active', 'border-secondary', 'border-bottom-0', 'text-white', 'bg-dark-custom');
                descTab.classList.remove('bg-transparent', 'text-white', 'border-0');
                
                reviewTab.classList.remove('active', 'border-secondary', 'border-bottom-0', 'text-white', 'bg-dark-custom');
                reviewTab.classList.add('bg-transparent', 'text-white', 'border-0');
                
                document.getElementById('desc').classList.add('show', 'active');
                document.getElementById('reviews').classList.remove('show', 'active');
            });
            
            reviewTab.addEventListener('click', function() {
                reviewTab.classList.add('active', 'border-secondary', 'border-bottom-0', 'text-white', 'bg-dark-custom');
                reviewTab.classList.remove('bg-transparent', 'text-white', 'border-0');
                
                descTab.classList.remove('active', 'border-secondary', 'border-bottom-0', 'text-white', 'bg-dark-custom');
                descTab.classList.add('bg-transparent', 'text-white', 'border-0');
                
                document.getElementById('reviews').classList.add('show', 'active');
                document.getElementById('desc').classList.remove('show', 'active');
            });
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let selectedVariantId = @if($product->variants->count() > 0) {{ $product->variants->first()->product_variant_id }} @else null @endif;

    if (!csrfToken) {
        console.error('CSRF token not found. AJAX add-to-cart will not work.');
        return;
    }

    console.log('Initial selectedVariantId:', selectedVariantId);
    console.log('CSRF Token exists:', !!csrfToken);
    console.log('Product variants count:', @json($product->variants->count()));
    console.log('Product variants:', @json($product->variants->toArray()));

    // Handle variant selection
    document.querySelectorAll('.variant-btn').forEach(button => {
        button.addEventListener('click', function() {
            console.log('Variant button clicked:', this.dataset);
            // Remove active class from all buttons
            document.querySelectorAll('.variant-btn').forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            // Update selected variant
            selectedVariantId = this.dataset.variantId;
            const price = this.dataset.price;
            const stock = this.dataset.stock;

            console.log('Updated selectedVariantId:', selectedVariantId);

            // Update price display
            document.getElementById('product-price').textContent = new Intl.NumberFormat('vi-VN').format(price) + '₫';

            // Update stock info
            document.getElementById('stock-info').textContent = 'Kho: ' + stock + ' sản phẩm';

            // Enable/disable add to cart button
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            addToCartBtn.disabled = stock == 0;
        });
    });

    // Handle add to cart
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        console.log('Add to cart clicked');
        console.log('selectedVariantId:', selectedVariantId);
        console.log('Product has variants:', @json($product->variants->count() > 0));

        if (@json($product->variants->count() == 0)) {
            alert('Sản phẩm này hiện không có phiên bản nào để mua');
            return;
        }

        if (!selectedVariantId) {
            alert('Vui lòng chọn phiên bản sản phẩm');
            return;
        }

        const quantity = parseInt(document.getElementById('qtyInput').value);
        console.log('Quantity:', quantity);

        if (quantity < 1) {
            alert('Số lượng phải lớn hơn 0');
            return;
        }

        const requestData = {
            product_variant_id: selectedVariantId,
            quantity: quantity
        };
        console.log('Request data:', requestData);

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(requestData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.message) {
                alert(data.message);
                // Optionally update cart count in header
                updateCartCount();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi thêm vào giỏ hàng');
        });
    });

    function updateCartCount() {
        fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            // Update cart count in header if exists
            const cartCountElement = document.querySelector('.cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
            }
        })
        .catch(error => console.error('Error updating cart count:', error));
    }
});

function increaseQty() {
    const qtyInput = document.getElementById('qtyInput');
    qtyInput.value = parseInt(qtyInput.value) + 1;
}

function decreaseQty() {
    const qtyInput = document.getElementById('qtyInput');
    const currentValue = parseInt(qtyInput.value);
    if (currentValue > 1) {
        qtyInput.value = currentValue - 1;
    }
}
</script>
@endsection
@endsection
