@extends('layouts.master')

@section('title', 'Thêm Danh Mục Mới - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card bg-dark-custom border-danger text-light shadow-lg">
            <div class="card-header bg-laravel text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-folder-plus me-2"></i>Thêm Danh Mục Mới</h5>
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-light text-laravel fw-bold">
                    <i class="bi bi-list-ul me-1"></i> Danh sách
                </a>
            </div>
            
            <div class="card-body p-4 bg-dark-custom">
                @if ($errors->any())
                    <div class="alert alert-danger border-danger bg-dark-custom text-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-laravel fw-bold">
                            Tên Danh Mục <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control bg-dark text-light border-secondary @error('name') is-invalid border-danger @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="VD: Laptop, Chuột, Bàn phím..." 
                               required>
                        @error('name')
                            <div class="invalid-feedback text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Làm Lại
                        </button>
                        <button type="submit" class="btn btn-laravel px-4">
                            <i class="bi bi-save me-1"></i> Lưu Danh Mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Custom styling matching the dark-tech theme */
    .form-control:focus {
        background-color: #1f2937;
        color: #f3f4f6;
        border-color: var(--laravel-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 45, 32, 0.25);
    }
    .form-control::placeholder {
        color: #6b7280;
    }
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .alert-danger {
        border-radius: 8px;
    }
</style>
@endsection
