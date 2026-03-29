@extends('layouts.master')

@section('title', 'Quản Lý Danh Mục - ElectroGear')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-dark-custom border-danger text-light shadow-lg mb-4">
            <div class="card-header bg-laravel text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-list-task me-2"></i>Danh Sách Danh Mục</h5>
                <a href="{{ route('categories.create') }}" class="btn btn-sm btn-light text-laravel fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Thêm Mới
                </a>
            </div>
            
            <div class="card-body p-4 bg-dark-custom">
                @if (session('success'))
                    <div class="alert alert-success bg-dark-custom border-success text-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered border-secondary table-striped align-middle mb-0">
                        <thead class="table-active">
                            <tr>
                                <th scope="col" width="5%" class="text-center text-laravel">#</th>
                                <th scope="col" width="30%" class="text-laravel">Tên Danh Mục</th>
                                <th scope="col" width="35%" class="text-laravel">Đường dẫn (Slug)</th>
                                <th scope="col" width="15%" class="text-center text-laravel">Ngày tạo</th>
                                <th scope="col" width="15%" class="text-center text-laravel">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($category as $item)
                                <tr>
                                    <td class="text-center fw-bold">{{ $item->category_id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->slug }}</span></td>
                                    <td class="text-center text-secondary small">{{ $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="#" class="btn btn-sm btn-outline-info" title="Sửa">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger" title="Xóa" onclick="alert('Tính năng xóa chưa được kích hoạt ở Controller!')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                        Chưa có danh mục nào. Hãy ấn <strong>Thêm Mới</strong> để tạo dữ liệu!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Styling for the table in dark theme */
    .table-dark {
        --bs-table-bg: var(--dark-bg);
        --bs-table-striped-bg: #1f2937;
        --bs-table-active-bg: #17202b;
    }
    .table-bordered {
        border-color: #374151;
    }
    .table > :not(caption) > * > * {
        background-color: transparent !important;
        border-bottom-color: #374151;
    }
    .table-hover > tbody > tr:hover > * {
        background-color: #374151 !important;
        color: var(--text-light);
    }
    .btn-outline-info {
        color: #38bdf8;
        border-color: #38bdf8;
    }
    .btn-outline-info:hover {
        background-color: #38bdf8;
        color: #000;
        border-color: #38bdf8;
    }
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
</style>
@endsection
