@extends('layouts.master')

@section('title', 'Thanh Toán - ElectroGear')

@section('content')
<div class="row">
    <!-- Cột trái: Form thông tin -->
    <div class="col-lg-8 mb-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger">
            <h3 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Thông Tin Thanh Toán</h3>
            
            <form action="#" method="POST">
                @csrf
                <h5 class="text-laravel mb-3"><i class="bi bi-person-lines-fill me-2"></i>Thông tin liên hệ</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="fullname" class="form-label text-white">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="fullname" placeholder="Nguyễn Văn A" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label text-white">Số điện thoại <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control bg-dark text-white border-secondary" id="phone" placeholder="0909123456" required>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label text-white">Email</label>
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email" placeholder="email@example.com">
                    </div>
                </div>

                <h5 class="text-laravel mb-3 mt-5"><i class="bi bi-geo-alt-fill me-2"></i>Địa chỉ giao hàng</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label text-white">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Tỉnh/Thành</option>
                            <option value="sg">Hồ Chí Minh</option>
                            <option value="hn">Hà Nội</option>
                            <option value="dn">Đà Nẵng</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-white">Quận/Huyện <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Quận/Huyện</option>
                            <option value="1">Quận 1</option>
                            <option value="2">Quận Gò Vấp</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-white">Phường/Xã <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" required>
                            <option value="">Chọn Phường/Xã</option>
                            <option value="1">Phường Bến Nghé</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label text-white">Địa chỉ cụ thể (Số nhà, tên đường) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="address" placeholder="123 Trịnh Đình Thảo..." required>
                    </div>
                    <div class="col-md-12">
                        <label for="notes" class="form-label text-white">Ghi chú đơn hàng (Tùy chọn)</label>
                        <textarea class="form-control bg-dark text-white border-secondary" id="notes" rows="3" placeholder="Giao trong giờ hành chính..."></textarea>
                    </div>
                </div>

                <h5 class="text-laravel mb-3 mt-5"><i class="bi bi-wallet-fill me-2"></i>Phương thức thanh toán</h5>
                <div class="list-group mb-4">
                    <label class="list-group-item bg-dark border-secondary text-white d-flex align-items-center custom-radio-item">
                        <input class="form-check-input me-3 bg-dark border-secondary custom-radio" type="radio" name="paymentMethod" value="cod" checked>
                        <span>
                            <strong>Thanh toán khi nhận hàng (COD)</strong><br>
                            <small class="text-white">Nhận hàng và thanh toán trực tiếp cho nhân viên giao hàng.</small>
                        </span>
                    </label>
                    <label class="list-group-item bg-dark border-secondary text-white d-flex align-items-center custom-radio-item">
                        <input class="form-check-input me-3 bg-dark border-secondary custom-radio" type="radio" name="paymentMethod" value="vnpay">
                        <span>
                            <strong>Thanh toán qua VNPAY</strong><br>
                            <small class="text-white">Quét mã QR qua ứng dụng ngân hàng hoặc ví VNPAY.</small>
                        </span>
                    </label>
                    <label class="list-group-item bg-dark border-secondary text-white d-flex align-items-center custom-radio-item">
                        <input class="form-check-input me-3 bg-dark border-secondary custom-radio" type="radio" name="paymentMethod" value="momo">
                        <span>
                            <strong>Thanh toán qua ví MoMo</strong><br>
                            <small class="text-white">Thanh toán nhanh chóng, an toàn qua ví điện tử MoMo.</small>
                        </span>
                    </label>
                </div>
            </form>
        </div>
    </div>

    <!-- Cột phải: Tổng quan đơn hàng -->
    <div class="col-lg-4">
        <div class="bg-dark-custom p-4 rounded shadow border-bottom border-danger sticky-top" style="top: 20px;">
            <h4 class="text-white fw-bold border-start border-danger border-4 ps-3 mb-4">Đơn Hàng Của Bạn</h4>
            
            <div class="mb-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-light">Arduino Uno R3 (Chip Cắm) x 2</span>
                    <span class="text-laravel fw-bold">250.000₫</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-light">Cảm Biến Khí Gas MQ-2 x 1</span>
                    <span class="text-laravel fw-bold">40.000₫</span>
                </div>
            </div>
            
            <hr class="border-secondary">

            <ul class="list-group list-group-flush mb-4 bg-transparent">
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Tạm tính
                    <span>290.000₫</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Phí vận chuyển
                    <span>30.000₫</span>
                </li>
                <li class="list-group-item bg-transparent border-secondary d-flex justify-content-between align-items-center px-0 mt-2">
                    <span class="fs-5 text-white fw-bold">Tổng cộng</span>
                    <span class="fs-4 text-laravel fw-bold">320.000₫</span>
                </li>
            </ul>

            <button type="button" class="btn btn-laravel w-100 btn-lg shadow" onclick="alert('Tính năng đặt hàng đang được xây dựng!')">ĐẶT HÀNG NGAY <i class="bi bi-check-circle ms-2"></i></button>
            <div class="text-center mt-3">
                <a href="/cart" class="text-white text-decoration-none small hover-laravel"><i class="bi bi-arrow-left me-1"></i> Quay lại giỏ hàng</a>
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
