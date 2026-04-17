@extends('layouts.master')

@section('title', 'Đặt Hàng Thành Công - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="bg-dark-custom p-5 rounded shadow border-bottom border-danger">
            <div class="text-center mb-4">
                <h1 class="text-laravel fw-bold">Đặt Hàng Thành Công!</h1>
                <p class="text-white mb-0">Cảm ơn bạn đã đặt hàng tại ElectroGear.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success text-dark">{{ session('success') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning text-dark">{{ session('warning') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger text-dark">{{ session('error') }}</div>
            @endif

            <div class="bg-dark p-4 rounded border border-secondary mb-4">
                <h4 class="text-white fw-bold mb-3">Mã đơn hàng: <span class="text-laravel">#{{ $order->order_id }}</span></h4>
                <p class="text-light mb-2">Tổng tiền: <strong class="text-white">{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong></p>
                <p class="text-light mb-2">Phương thức thanh toán: <strong class="text-white">{{ $order->paymentMethod->name }}</strong></p>
                <p class="text-light">Trạng thái đơn hàng: <strong class="text-white text-capitalize">{{ $order->order_status }}</strong></p>
            </div>

            <div class="bg-dark p-4 rounded border border-secondary mb-4">
                <h5 class="text-laravel fw-bold mb-3">Thông tin giao hàng</h5>
                <p class="text-light mb-1">{{ $order->shippingAddress->recipient_name }}</p>
                <p class="text-light mb-1">{{ $order->shippingAddress->phone_number }}</p>
                <p class="text-light mb-0">{{ $order->shippingAddress->address_line }}</p>
            </div>

            <div class="bg-dark p-4 rounded border border-secondary">
                <h5 class="text-laravel fw-bold mb-3">Chi tiết sản phẩm</h5>
                @foreach($order->orderItems as $item)
                    <div class="d-flex justify-content-between text-light mb-2">
                        <div>
                            <strong>{{ $item->productVariant->product->name }}</strong>
                            <div class="small text-white-50">SKU: {{ $item->productVariant->sku }}</div>
                        </div>
                        <div class="text-right">
                            <div>{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}₫</div>
                            <div class="text-laravel fw-bold">{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}₫</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <a href="/products" class="btn btn-laravel btn-lg">Tiếp tục mua sắm</a>
                <a href="/" class="btn btn-outline-light btn-lg ms-2">Về trang chủ</a>
            </div>
        </div>
    </div>
</div>
@endsection