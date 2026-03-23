@extends('layouts.master')

@section('title', 'Liên Hệ - ElectroGear')

@section('content')
<div class="p-5 mb-5 bg-dark-custom text-white border-bottom border-danger shadow rounded">
    <h2 class="fw-bold mb-4 text-laravel border-start border-danger border-4 ps-3">Liên Hệ Với Chúng Tôi</h2>
    <div class="row g-4">
        <div class="col-md-6">
            <h4 class="mb-3">Thông tin liên hệ</h4>
            <p><i class="bi bi-geo-alt text-laravel me-2"></i> 123 Đường Công Nghệ, Quận 1, TP. HCM</p>
            <p><i class="bi bi-telephone text-laravel me-2"></i> 0123 456 789</p>
            <p><i class="bi bi-envelope text-laravel me-2"></i> contact@electrogear.com</p>
            <p><i class="bi bi-clock text-laravel me-2"></i> Giờ làm việc: 8:00 - 17:30 (Thứ 2 - Thứ 7)</p>
        </div>
        <div class="col-md-6">
            <h4 class="mb-3">Gửi tin nhắn cho chúng tôi</h4>
            <form action="#" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label text-white">Họ và tên</label>
                    <input type="text" class="form-control bg-dark text-light border-secondary" id="name" placeholder="Nhập tên của bạn">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <input type="email" class="form-control bg-dark text-light border-secondary" id="email" placeholder="Nhập email của bạn">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label text-white">Nội dung</label>
                    <textarea class="form-control bg-dark text-light border-secondary" id="message" rows="4" placeholder="Nhập nội dung tin nhắn..."></textarea>
                </div>
                <button type="button" class="btn btn-laravel w-100" onclick="alert('Cảm ơn bạn đã liên hệ, chúng tôi sẽ phản hồi sớm nhất!')">Gửi Liên Hệ</button>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: var(--laravel-red) !important;
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25) !important;
    }
</style>
@endsection
