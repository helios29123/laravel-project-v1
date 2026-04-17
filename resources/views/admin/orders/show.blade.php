@extends('layouts.master')

@section('title', 'Chi tiết đơn hàng - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="text-white fw-bold"><i class="bi bi-card-checklist me-2 text-laravel"></i>Đơn hàng #{{ $order->order_id }}</h4>
            <p class="text-secondary mb-0">Chi tiết đơn hàng và thông tin giao hàng.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-light">Quay lại danh sách</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success text-dark">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card bg-dark-custom border-secondary shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="text-white mb-3">Thông tin khách hàng</h5>
                <p class="text-secondary mb-1"><strong>Khách hàng:</strong> {{ $order->user->full_name ?? 'Không xác định' }}</p>
                <p class="text-secondary mb-1"><strong>Email:</strong> {{ $order->user->email ?? 'Không xác định' }}</p>
                <p class="text-secondary mb-1"><strong>Phương thức:</strong> {{ $order->paymentMethod->name ?? 'Không xác định' }}</p>
                <p class="text-secondary mb-1"><strong>Trạng thái:</strong> <span class="text-capitalize">{{ $order->order_status }}</span></p>
                <p class="text-secondary mb-0"><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card bg-dark-custom border-secondary shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="text-white mb-3">Địa chỉ giao hàng</h5>
                @if($order->shippingAddress)
                    <p class="text-secondary mb-1"><strong>Người nhận:</strong> {{ $order->shippingAddress->recipient_name }}</p>
                    <p class="text-secondary mb-1"><strong>Số điện thoại:</strong> {{ $order->shippingAddress->phone_number }}</p>
                    <p class="text-secondary mb-0"><strong>Địa chỉ:</strong> {{ $order->shippingAddress->address_line }}</p>
                @else
                    <p class="text-secondary">Không có thông tin địa chỉ.</p>
                @endif
            </div>
        </div>

        <div class="card bg-dark-custom border-secondary shadow-sm">
            <div class="card-body p-4">
                <h5 class="text-white mb-3">Sản phẩm trong đơn</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>SKU</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->productVariant->product->name ?? 'Sản phẩm đã xoá' }}</td>
                                    <td>{{ $item->productVariant->sku ?? '-' }}</td>
                                    <td>{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card bg-dark-custom border-secondary shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="text-white mb-3">Tóm tắt</h5>
                <p class="text-secondary mb-2"><strong>Tổng tiền hàng:</strong> {{ number_format($order->total_amount - $order->shipping_fee, 0, ',', '.') }}₫</p>
                <p class="text-secondary mb-2"><strong>Phí giao hàng:</strong> {{ number_format($order->shipping_fee, 0, ',', '.') }}₫</p>
                <hr class="border-secondary">
                <p class="text-white fw-bold fs-5">Tổng cộng: {{ number_format($order->total_amount, 0, ',', '.') }}₫</p>
            </div>
        </div>

        <div class="card bg-dark-custom border-secondary shadow-sm">
            <div class="card-body p-4">
                <h5 class="text-white mb-3">Cập nhật trạng thái</h5>
                <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label text-white">Trạng thái đơn</label>
                        <select name="order_status" class="form-select bg-dark text-white border-secondary">
                            @foreach(['pending','paid','processing','shipped','completed','cancelled','failed'] as $status)
                                <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-laravel w-100">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
