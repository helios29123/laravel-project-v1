@extends('layouts.master')

@section('title', 'Đăng Ký - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-6 mb-5">
        <div class="bg-dark-custom p-5 rounded shadow border-bottom border-danger">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus text-laravel" style="font-size: 3rem;"></i>
                <h3 class="text-white fw-bold mt-2">Đăng Ký Tài Khoản</h3>
                <p class="text-white">Tham gia cùng cộng đồng <span class="text-laravel">ElectroGear</span></p>
            </div>
            
            <form action="#" method="POST">
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label text-white">Họ</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="firstname" placeholder="Nguyễn" required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label text-white">Tên</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="lastname" placeholder="Văn A" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email" placeholder="name@example.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label text-white">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-telephone"></i></span>
                        <input type="tel" class="form-control bg-dark text-white border-secondary" id="phone" placeholder="0909123456" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-white">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-text text-white small">Mật khẩu phải chứa ít nhất 8 ký tự.</div>
                </div>

                <div class="mb-4">
                    <label for="password_confirm" class="form-label text-white">Xác nhận mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-shield-check"></i></span>
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password_confirm" placeholder="••••••••" required>
                    </div>
                </div>
                
                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input bg-dark border-secondary custom-checkbox" id="terms" required>
                    <label class="form-check-label text-white small" for="terms">
                        Tôi đồng ý với các <a href="#" class="text-laravel hover-light">Điều khoản dịch vụ</a> và <a href="#" class="text-laravel hover-light">Chính sách bảo mật</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-laravel w-100 btn-lg shadow mb-3">Tạo Tài Khoản</button>

                <div class="text-center mt-3 text-white small">
                    Đã có tài khoản? <a href="/login" class="text-laravel fw-bold text-decoration-none hover-light">Đăng Nhập</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-check-input:focus {
        border-color: var(--laravel-red) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25) !important;
    }
    .custom-checkbox:checked {
        background-color: var(--laravel-red);
        border-color: var(--laravel-red);
    }
    .hover-light:hover {
        color: white !important;
        transition: color 0.2s;
    }
</style>
@endsection
