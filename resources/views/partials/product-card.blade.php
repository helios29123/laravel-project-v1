<div class="col">
    <div class="card h-100 bg-dark-custom border-danger product-card shadow">
        <div class="position-relative overflow-hidden product-img-wrapper p-2">
            <!-- Xử lý ảnh sản phẩm, nếu không có lấy ảnh placeholder -->
            <a href="{{ route('product.show', $product->product_id) }}">
                <img src="{{ isset($product->image) && $product->image ? (str_starts_with($product->image, 'http') ? $product->image : asset('storage/'.$product->image)) : 'https://dummyimage.com/600x600/1f2937/ff2d20&text=' . urlencode(substr($product->name, 0, 15)) }}" class="card-img-top product-img" alt="{{ $product->name }}">
            </a>
            
            @if(isset($badge))
                <span class="position-absolute top-0 start-0 m-2 badge bg-danger shadow z-1">{{ $badge }}</span>
            @endif

            <div class="overlay d-flex justify-content-center align-items-center rounded">
                <a href="#" class="btn btn-laravel rounded-circle me-2 p-2 shadow-lg action-btn text-white" title="Thêm vào giỏ" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="bi bi-cart-plus fs-5"></i></a>
                <a href="{{ route('product.show', $product->product_id) }}" class="btn btn-outline-light rounded-circle p-2 shadow-lg action-btn" title="Xem chi tiết" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;text-decoration:none;"><i class="bi bi-eye fs-5"></i></a>
            </div>
        </div>
        <div class="card-body d-flex flex-column p-3">
            <a href="{{ route('product.show', $product->product_id) }}" class="text-decoration-none">
                <h5 class="card-title text-white flex-grow-1 header-hover mb-2" style="font-size: 1.1rem; line-height: 1.4;" title="{{ $product->name }}">{{ $product->name }}</h5>
            </a>
            
            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-laravel fw-bold" style="font-size: 1.1rem;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    <span class="badge bg-success" style="font-size: 0.70rem;">Còn hàng</span>
                </div>
                
                <!-- Đánh giá sao giả lập cho đẹp UI -->
                <div class="text-warning d-flex align-items-center" style="font-size: 0.8rem; height: 20px;">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i>
                    <span class="text-white ms-1">(12)</span>
                </div>
            </div>
        </div>
    </div>
</div>
