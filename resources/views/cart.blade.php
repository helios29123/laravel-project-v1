@extends('layouts.master')

@section('title', 'Giỏ Hàng - ElectroGear')

@section('content')
<div class="row">
    <!-- Cột trái: Danh sách sản phẩm -->
    <div class="col-lg-8 mb-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Giỏ Hàng Của Bạn</h3>
            
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle custom-table">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 50%;">Sản phẩm</th>
                            <th scope="col" class="text-center">Đơn giá</th>
                            <th scope="col" class="text-center" style="width: 15%;">Số lượng</th>
                            <th scope="col" class="text-end">Thành tiền</th>
                            <th scope="col" class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items">
                        @forelse($cartItems as $item)
                        <tr data-variant-id="{{ $item->product_variant_id }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->productVariant->product->images->first()?->image_url ?? 'https://via.placeholder.com/60x60/1f2937/ff2d20?text=No+Image' }}" class="rounded me-3 border border-secondary" alt="Product Image" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 text-white header-hover">{{ $item->productVariant->product->name }}</h6>
                                        <small class="text-white">Mã SP: {{ $item->productVariant->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-light">{{ number_format($item->productVariant->price, 0, ',', '.') }}₫</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                    <input type="text" class="form-control text-center bg-dark text-white border-secondary quantity-input" value="{{ $item->quantity }}" readonly>
                                    <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                </div>
                            </td>
                            <td class="text-end fw-bold text-laravel item-total">{{ number_format($item->quantity * $item->productVariant->price, 0, ',', '.') }}₫</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger shadow-sm btn-remove"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-cart-x fs-1 mb-3"></i>
                                <p>Giỏ hàng của bạn đang trống</p>
                                <a href="/products" class="btn btn-laravel">Bắt đầu mua sắm</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/products" class="btn btn-outline-light"><i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm</a>
                <button class="btn btn-outline-secondary"><i class="bi bi-arrow-clockwise me-2"></i>Cập nhật giỏ hàng</button>
            </div>
        </div>
    </div>

    <!-- Cột phải: Tổng quan đơn hàng -->
    <div class="col-lg-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger sticky-top" style="top: 20px;">
            <h4 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Tóm Tắt Đơn Hàng</h4>
            
            <ul class="list-group list-group-flush mb-4 bg-transparent">
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Tạm tính
                    <span id="subtotal">{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Phí vận chuyển
                    <span id="shipping-fee">{{ number_format($shippingFee, 0, ',', '.') }}₫</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Giảm giá
                    <span class="text-success" id="discount">-{{ number_format($discount, 0, ',', '.') }}₫</span>
                </li>
                <li class="list-group-item bg-transparent border-secondary d-flex justify-content-between align-items-center px-0 mt-2">
                    <span class="fs-5 text-white fw-bold">Tổng cộng</span>
                    <span class="fs-4 text-laravel fw-bold" id="total">{{ number_format($total, 0, ',', '.') }}₫</span>
                </li>
            </ul>

            <div class="mb-4">
                <label class="form-label text-white small">Mã giảm giá (nếu có)</label>
                <div class="input-group">
                    <input type="text" class="form-control bg-dark text-white border-secondary" placeholder="Nhập mã">
                    <button class="btn btn-outline-secondary" type="button">Áp dụng</button>
                </div>
            </div>

            <a href="/checkout" class="btn btn-laravel w-100 btn-lg shadow">Tiến Hành Thanh Toán <i class="bi bi-arrow-right ms-2"></i></a>
        </div>
    </div>
</div>

<style>
    .custom-table th {
        border-bottom-color: var(--laravel-red);
        color: #9ca3af;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
    }
    .custom-table td {
        border-bottom-color: #374151;
        vertical-align: middle;
    }
    .custom-table tbody tr:hover td {
        background-color: rgba(255, 255, 255, 0.05);
    }
    .header-hover {
        transition: color 0.2s;
        cursor: pointer;
    }
    .header-hover:hover {
        color: var(--laravel-red) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!csrfToken) {
        console.error('CSRF token not found. AJAX cart actions will not work.');
        return;
    }

    // Handle quantity increase
    document.querySelectorAll('.btn-increase').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const variantId = row.dataset.variantId;
            const quantityInput = row.querySelector('.quantity-input');
            const currentQty = parseInt(quantityInput.value);
            updateCartItem(variantId, currentQty + 1);
        });
    });

    // Handle quantity decrease
    document.querySelectorAll('.btn-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const variantId = row.dataset.variantId;
            const quantityInput = row.querySelector('.quantity-input');
            const currentQty = parseInt(quantityInput.value);
            if (currentQty > 1) {
                updateCartItem(variantId, currentQty - 1);
            }
        });
    });

    // Handle remove item
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            const variantId = row.dataset.variantId;
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                removeCartItem(variantId);
            }
        });
    });

    function updateCartItem(variantId, quantity) {
        fetch('/cart/update', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_variant_id: variantId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                if (data.message.includes('cập nhật')) {
                    location.reload(); // Reload to show updated cart
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi cập nhật giỏ hàng');
        });
    }

    function removeCartItem(variantId) {
        fetch('/cart/remove', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                product_variant_id: variantId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                location.reload(); // Reload to show updated cart
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa sản phẩm');
        });
    }
});
</script>
@endsection
