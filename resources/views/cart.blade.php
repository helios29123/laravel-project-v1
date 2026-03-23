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
                    <tbody>
                        <!-- Item 1 -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/60x60/1f2937/ff2d20?text=Arduino" class="rounded me-3 border border-secondary" alt="Product Image">
                                    <div>
                                        <h6 class="mb-0 text-white header-hover">Arduino Uno R3 (Chip Cắm)</h6>
                                        <small class="text-white">Mã SP: EG-001</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-light">125.000₫</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control text-center bg-dark text-white border-secondary" value="2">
                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                </div>
                            </td>
                            <td class="text-end fw-bold text-laravel">250.000₫</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Item 2 -->
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/60x60/1f2937/ff2d20?text=Sensor" class="rounded me-3 border border-secondary" alt="Product Image">
                                    <div>
                                        <h6 class="mb-0 text-white header-hover">Cảm Biến Khí Gas MQ-2</h6>
                                        <small class="text-white">Mã SP: EG-045</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-light">40.000₫</td>
                            <td>
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                    <input type="text" class="form-control text-center bg-dark text-white border-secondary" value="1">
                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                </div>
                            </td>
                            <td class="text-end fw-bold text-laravel">40.000₫</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-danger shadow-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
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
                    <span>290.000₫</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Phí vận chuyển
                    <span>30.000₫</span>
                </li>
                <li class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center px-0">
                    Giảm giá
                    <span class="text-success">-0₫</span>
                </li>
                <li class="list-group-item bg-transparent border-secondary d-flex justify-content-between align-items-center px-0 mt-2">
                    <span class="fs-5 text-white fw-bold">Tổng cộng</span>
                    <span class="fs-4 text-laravel fw-bold">320.000₫</span>
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
@endsection
