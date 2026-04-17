@extends('layouts.master')

@section('title', 'Thanh Toán - ElectroGear')

@section('content')
<div class="row">
    <!-- Cột trái: Form thông tin -->
    <div class="col-lg-8 mb-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Thông Tin Thanh Toán</h3>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger bg-danger text-white border-0 mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-warning bg-warning text-dark border-0 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <h5 class="text-laravel mb-3"><i class="bi bi-person-lines-fill me-2"></i>Thông tin liên hệ</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="fullname" class="form-label text-white">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="fullname" class="form-control bg-dark text-white border-secondary" id="fullname" placeholder="Nguyễn Văn A" value="{{ old('fullname', $shippingAddress->recipient_name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label text-white">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control bg-dark text-white border-secondary" id="phone" placeholder="0909123456" value="{{ old('phone', $shippingAddress->phone_number ?? '') }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label text-white">Email</label>
                        <input type="email" name="email" class="form-control bg-dark text-white border-secondary" id="email" placeholder="email@example.com" value="{{ old('email') }}">
                    </div>
                </div>

                <h5 class="text-laravel mb-3 mt-5"><i class="bi bi-geo-alt-fill me-2"></i>Địa chỉ giao hàng</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="city" class="form-label text-white">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                        <select name="city" id="city" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Tỉnh/Thành</option>
                            <option value="Hồ Chí Minh" {{ old('city', $shippingAddress->city ?? '') === 'Hồ Chí Minh' ? 'selected' : '' }}>Hồ Chí Minh</option>
                            <option value="Hà Nội" {{ old('city', $shippingAddress->city ?? '') === 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                            <option value="Đà Nẵng" {{ old('city', $shippingAddress->city ?? '') === 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="district" class="form-label text-white">Quận/Huyện <span class="text-danger">*</span></label>
                        <select name="district" id="district" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Quận/Huyện</option>
                            <option value="Quận 1" {{ old('district') === 'Quận 1' ? 'selected' : '' }}>Quận 1</option>
                            <option value="Quận Gò Vấp" {{ old('district') === 'Quận Gò Vấp' ? 'selected' : '' }}>Quận Gò Vấp</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="ward" class="form-label text-white">Phường/Xã <span class="text-danger">*</span></label>
                        <select name="ward" id="ward" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Phường/Xã</option>
                            <option value="Phường Bến Nghé" {{ old('ward') === 'Phường Bến Nghé' ? 'selected' : '' }}>Phường Bến Nghé</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label text-white">Địa chỉ cụ thể (Số nhà, tên đường) <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control bg-dark text-white border-secondary" id="address" placeholder="123 Trịnh Đình Thảo..." value="{{ old('address') }}" required>
                    </div>
                    <div class="col-md-12">
                        <label for="notes" class="form-label text-white">Ghi chú đơn hàng (Tùy chọn)</label>
                        <textarea name="notes" class="form-control bg-dark text-white border-secondary" id="notes" rows="3" placeholder="Giao trong giờ hành chính...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <h5 class="text-laravel mb-3 mt-5"><i class="bi bi-wallet-fill me-2"></i>Phương thức thanh toán</h5>
                <div class="list-group mb-4">
                    @foreach($paymentMethods as $method)
                        <label class="list-group-item bg-dark border-secondary text-white d-flex align-items-center custom-radio-item">
                            <input class="form-check-input me-3 bg-dark border-secondary custom-radio" type="radio" name="payment_method" value="{{ $method['code'] }}" {{ old('payment_method', 'cod') === $method['code'] ? 'checked' : '' }}>
                            <span>
                                <strong>{{ $method['name'] }}</strong><br>
                                <small class="text-white">{{ $method['code'] === 'cod' ? 'Nhận hàng và thanh toán trực tiếp cho nhân viên giao hàng.' : ($method['code'] === 'vnpay' ? 'Quét mã QR qua ứng dụng ngân hàng hoặc ví VNPAY.' : 'Thanh toán nhanh chóng, an toàn qua ví điện tử MoMo.') }}</small>
                            </span>
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-laravel btn-lg px-4 shadow w-100">ĐẶT HÀNG NGAY <i class="bi bi-check-circle ms-2"></i></button>
            </form>
        </div>
    </div>

    <!-- Cột phải: Tổng quan đơn hàng -->
    <div class="col-lg-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger sticky-top" style="top: 20px;">
            <h4 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Đơn Hàng Của Bạn</h4>

            @if($cartItems->isEmpty())
                <div class="text-center text-light py-5">
                    <p>Giỏ hàng của bạn đang trống.</p>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light">Quay lại giỏ hàng</a>
                </div>
            @else
                <div class="mb-4">
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-light">{{ $item->productVariant->product->name }} x {{ $item->quantity }}</span>
                            <span class="text-laravel fw-bold">{{ number_format($item->quantity * $item->productVariant->price, 0, ',', '.') }}₫</span>
                        </div>
                    @endforeach
                </div>

                <hr class="border-secondary">

                <ul class="list-group list-group-flush mb-4 bg-transparent">
                    <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                        Tạm tính
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </li>
                    <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                        Phí vận chuyển
                        <span>{{ number_format($shippingFee, 0, ',', '.') }}₫</span>
                    </li>
                    <li class="list-group-item bg-transparent border-secondary d-flex justify-content-between align-items-center px-0 mt-2">
                        <span class="fs-5 text-white fw-bold">Tổng cộng</span>
                        <span class="fs-4 text-laravel fw-bold">{{ number_format($total, 0, ',', '.') }}₫</span>
                    </li>
                </ul>
            @endif

            <div class="text-center mt-3">
                <a href="{{ route('cart.index') }}" class="text-white text-decoration-none small hover-laravel"><i class="bi bi-arrow-left me-1"></i> Quay lại giỏ hàng</a>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: var(--laravel-red) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25) !important;
    }
    .custom-radio:checked {
        background-color: var(--laravel-red);
        border-color: var(--laravel-red);
    }
    .custom-radio-item {
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .custom-radio-item:hover {
        background-color: rgba(255, 45, 32, 0.05) !important;
    }
    .hover-laravel:hover {
        color: var(--laravel-red) !important;
    }
</style>
@endsection
