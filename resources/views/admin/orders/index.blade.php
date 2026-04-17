@extends('layouts.master')

@section('title', 'Quản lý đơn hàng - Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="text-white fw-bold"><i class="bi bi-cart-check-fill me-2 text-laravel"></i>Quản Lý Đơn Hàng</h4>
        <p class="text-secondary">Xem, lọc và cập nhật trạng thái các đơn hàng mới nhất.</p>
    </div>
</div>

<div class="card bg-dark-custom border-secondary shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ $order->user->full_name ?? 'Khách' }}</td>
                            <td>{{ $order->paymentMethod->name ?? 'Chưa xác định' }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            <td class="text-capitalize">{{ $order->order_status }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-light">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-white py-4">Chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
