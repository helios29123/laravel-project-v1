@extends('layouts.master')

@section('title', 'Quản Lý Sản Phẩm - ElectroGear')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="text-white fw-bold"><i class="bi bi-box-seam me-2 text-laravel"></i>Danh Sách Sản Phẩm</h4>
        <p class="text-secondary mb-0">Quản lý kho hàng và các thông số cài đặt</p>
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-laravel">
        <i class="bi bi-plus-lg me-1"></i>Thêm Sản Phẩm Mới
    </a>
</div>

@if(session('success'))
<div class="alert alert-success bg-dark-custom text-success border-success mb-4 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

<div class="card bg-dark-custom border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="80" class="text-center">ID</th>
                        <th width="80" class="text-center">Ảnh</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Danh Mục</th>
                        <th>Mức Giá (VNĐ)</th>
                        <th>Biến Thể (Kho)</th>
                        <th width="100" class="text-center">Trạng Thái</th>
                        <th width="140" class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($products as $product)
                    <tr>
                        <!-- Cột ID -->
                        <td class="text-center text-secondary">#{{ $product->product_id }}</td>
                        
                        <!-- Cột Ảnh đại diện vòng lặp (lấy ảnh đầu tiên) -->
                        <td class="text-center">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}" class="rounded shadow-sm" style="width: 55px; height: 55px; object-fit: cover; border: 1px solid #374151;">
                            @else
                                <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto" style="width: 55px; height: 55px;">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        
                        <!-- Cột Tên -->
                        <td>
                            <strong class="text-white d-block mb-1">{{ Str::limit($product->name, 50) }}</strong>
                            <span class="text-secondary small line-clamp-1">{{ Str::limit($product->description, 40) }}</span>
                        </td>
                        
                        <!-- Cột Danh mục -->
                        <td>
                            <span class="badge border border-secondary text-light px-2 py-1"><i class="bi bi-tag me-1"></i>{{ $product->category->name ?? 'Không phân loại' }}</span>
                        </td>
                        
                        <!-- Cột Mức Giá Tổng Hợp -->
                        <td>
                            @php
                                $variantCount = $product->variants->count();
                                $minPrice = $product->variants->min('price');
                                $maxPrice = $product->variants->max('price');
                            @endphp
                            <span class="text-laravel fw-bold fs-6">
                                @if($variantCount <= 1 || $minPrice == $maxPrice)
                                    {{ number_format($minPrice ?? 0, 0, ',', '.') }}đ
                                @else
                                    {{ number_format($minPrice, 0, ',', '.') }}đ <span class="text-secondary fw-normal mx-1">-</span> {{ number_format($maxPrice, 0, ',', '.') }}đ
                                @endif
                            </span>
                        </td>

                        <!-- Cột Chứa Số lượng và Biến thể -->
                        <td>
                            @php
                                $totalStock = $product->variants->sum('stock_quantity');
                            @endphp
                            
                            @if($variantCount > 1)
                                <div class="text-info small fw-semibold"><i class="bi bi-layers me-1"></i>{{ $variantCount }} Biến thể</div>
                                <div class="text-secondary small mt-1">Tổng kho: <strong>{{ $totalStock }}</strong></div>
                            @else
                                <div class="text-secondary small">Sản phẩm đơn</div>
                                <div class="text-secondary small mt-1">Kho: <strong>{{ $totalStock }}</strong></div>
                            @endif
                        </td>
                        
                        <!-- Cột Status -->
                        <td class="text-center">
                            @if($product->status == 'active')
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-circle-fill small me-1" style="font-size: 8px;"></i>Hiển thị</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-eye-slash-fill me-1"></i>Đã ẩn</span>
                            @endif
                        </td>
                        
                        <!-- Cột Chức Năng (CRUD) -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-sm btn-dark border-secondary text-info hover-glow-info" title="Xem chi tiết (sẽ phát triển)"><i class="bi bi-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-dark border-secondary text-warning hover-glow-warning" title="Sửa (sẽ phát triển)"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO MẤT DỮ LIỆU!\nBạn có chắn chắn muốn xóa sản phẩm này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-dark border-secondary text-danger hover-glow-danger" title="Xóa"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-box2 fs-1 text-secondary d-block mb-3 opacity-50"></i>
                            <h5 class="text-secondary fw-bold">Kho Hàng Trống</h5>
                            <p class="text-muted">Chưa có bất kỳ sản phẩm nào được tạo. Hãy bóc tem dự án ngay!</p>
                            <a href="{{ route('products.create') }}" class="btn btn-laravel mt-2 px-4 shadow-sm">
                                TẠO MỚI SẢN PHẨM
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Phân trang (Pagination) -->
    @if($products->hasPages())
    <div class="card-footer border-secondary bg-transparent pt-3 pb-3 text-center d-flex justify-content-center">
         {{ $products->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<style>
    /* Table Dark Theme Tinh chỉnh */
    .table-dark {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(255, 255, 255, 0.02);
        --bs-table-border-color: #374151; /* Màu viền của card */
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05); /* Hiệu ứng rà chuột sáng lên xíu */
    }
    .table > :not(caption) > * > * {
        padding: 1.25rem 0.75rem; /* Tăng padding để dòng to rõ rành */
    }
    
    /* Hiệu ứng Glow cho các nút bấm Action */
    .hover-glow-info:hover { box-shadow: 0 0 10px rgba(13, 202, 240, 0.5); border-color: #0dcaf0 !important; }
    .hover-glow-warning:hover { box-shadow: 0 0 10px rgba(255, 193, 7, 0.5); border-color: #ffc107 !important; }
    .hover-glow-danger:hover { box-shadow: 0 0 10px rgba(220, 53, 69, 0.5); border-color: #dc3545 !important; background-color: #dc3545; color: white !important;}
    
    /* CSS cho phân trang (Pagination) hợp với giao diện Đen */
    .pagination { margin-bottom: 0; }
    .page-link { 
        background-color: var(--dark-surface);
        border-color: #374151;
        color: var(--text-light);
    }
    .page-link:hover {
        background-color: #374151;
        color: white;
        border-color: #4b5563;
    }
    .page-item.active .page-link {
        background-color: var(--laravel-red);
        border-color: var(--laravel-red);
        color: white;
        box-shadow: 0 0 10px rgba(255, 45, 32, 0.5);
    }
    .page-item.disabled .page-link {
        background-color: var(--darker-bg);
        border-color: #374151;
        color: #6b7280;
    }
    
    /* Tiện ích ẩn bớt text dài */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection
