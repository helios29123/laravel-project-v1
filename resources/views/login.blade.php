@extends('layouts.master')

@section('title', 'Đăng Nhập - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 mb-5">
        <div class="bg-dark-custom p-5 rounded shadow border-bottom border-danger">
            <div class="text-center mb-4">
                <i class="bi bi-cpu text-laravel" style="font-size: 3rem;"></i>
                <h3 class="text-white fw-bold mt-2">Đăng Nhập</h3>
                <p class="text-white">Chào mừng trở lại với <span class="text-laravel">ElectroGear</span></p>
            </div>
            
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control bg-dark text-white border-secondary" id="email" placeholder="name@example.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-laravel"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control bg-dark text-white border-secondary" id="password" placeholder="••••••••" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input bg-dark border-secondary custom-checkbox" id="remember">
                        <label class="form-check-label text-white small" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="#" class="text-laravel text-decoration-none small hover-light">Quên mật khẩu?</a>
                </div>

                <button type="submit" class="btn btn-laravel w-100 btn-lg shadow mb-3">Đăng Nhập</button>
                
                <div class="position-relative text-center my-4">
                    <hr class="border-secondary">
                    <span class="position-absolute top-50 start-50 translate-middle bg-dark-custom px-2 text-white small">HOẶC LỰA CHỌN</span>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-light d-flex align-items-center justify-content-center" type="button">
                        <i class="bi bi-google text-danger me-2"></i> Đăng nhập bằng Google
                    </button>
                    <button class="btn btn-outline-light d-flex align-items-center justify-content-center" type="button">
                        <i class="bi bi-github text-white me-2"></i> Đăng nhập bằng Github
                    </button>
                </div>

                <div class="text-center mt-4 text-white small">
                    Chưa có tài khoản? <a href="/register" class="text-laravel fw-bold text-decoration-none hover-light">Đăng Ký Ngay</a>
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
