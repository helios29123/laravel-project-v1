@extends('layouts.master')

@section('title', 'Lịch sử đơn hàng của tôi')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="text-white fw-bold"><i class="bi bi-clock-history me-2 text-laravel"></i>Lịch sử đơn hàng</h4>
        <p class="text-secondary">Xem lại các đơn hàng đã đặt và trạng thái giao hàng.</p>
    </div>
</div>

<div class="card bg-dark-custom border-secondary shadow-sm">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Tổng tiền</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ number_format($order->total_amount, 0, ',', '.') }}₫</td>
                            <td>{{ $order->paymentMethod->name ?? 'Chưa xác định' }}</td>
                            <td class="text-capitalize">{{ $order->order_status }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->order_id) }}" class="btn btn-sm btn-outline-light">Xem</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-white py-4">Bạn chưa có đơn hàng nào.</td>
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
