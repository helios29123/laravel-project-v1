@extends('layouts.master')

@section('title', 'Thêm Sản Phẩm Mới - ElectroGear')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="card bg-dark-custom border-danger text-light shadow-lg">
            <div class="card-header bg-laravel text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-box-seam me-2"></i>Thêm Sản Phẩm Mới</h5>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-light text-laravel fw-bold">
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

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label text-laravel fw-bold">
                                Tên Sản Phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control bg-dark text-light border-secondary @error('name') is-invalid border-danger @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Nhập tên sản phẩm..." 
                                   required>
                            @error('name')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label text-laravel fw-bold">
                                Danh Mục <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" id="category_id" 
                                    class="form-select bg-dark text-light border-secondary @error('category_id') is-invalid border-danger @enderror" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label text-laravel fw-bold">
                                Giá Sản Phẩm (VNĐ) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control bg-dark text-light border-secondary @error('price') is-invalid border-danger @enderror" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price') }}" 
                                   placeholder="Nhập giá..." 
                                   min="0" required>
                            @error('price')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="stock" class="form-label text-laravel fw-bold">
                                Số Lượng Tồn Kho <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control bg-dark text-light border-secondary @error('stock') is-invalid border-danger @enderror" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock') }}" 
                                   placeholder="Nhập số lượng..." 
                                   min="0" required>
                            @error('stock')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- AJAX Dynamic Attributes Container -->
                    <div class="row mb-3" id="dynamic-attributes-container"></div>

                    <!-- Variants Table -->
                    <div id="variants-table-container" class="mb-4 d-none">
                        <h6 class="text-laravel fw-bold"><i class="bi bi-list-nested me-1"></i> Biến Thể Sản Phẩm</h6>
                        <div class="table-responsive">
                            <table class="table table-dark table-bordered border-secondary align-middle">
                                <thead class="table-active text-center">
                                    <tr>
                                        <th>Loại Biến Thể</th>
                                        <th>Mã SKU</th>
                                        <th>Giá (VNĐ)</th>
                                        <th>Số Lượng Tồn</th>
                                    </tr>
                                </thead>
                                <tbody id="variants-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label text-laravel fw-bold">
                            Hình Ảnh Sản Phẩm <span class="text-danger">*</span>
                        </label>
                        <input type="file" 
                               class="form-control bg-dark text-light border-secondary @error('image') is-invalid border-danger @enderror" 
                               id="image" 
                               name="image" 
                               accept="image/*" required>
                        <div class="form-text text-secondary mt-1">Định dạng: jpeg, png, jpg, gif, dung lượng tối đa 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                        @enderror
                        <div id="imagePreviewContainer" class="mt-3" style="display: none;">
                            <img id="imagePreview" src="" class="img-thumbnail bg-dark border-secondary" style="max-height: 150px; border-radius: 8px;" alt="Preview">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label text-laravel fw-bold">
                            Mô Tả Sản Phẩm <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control bg-dark text-light border-secondary @error('description') is-invalid border-danger @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Nhập mô tả sản phẩm..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="reset" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Làm Lại
                        </button>
                        <button type="submit" class="btn btn-laravel px-4">
                            <i class="bi bi-save me-1"></i> Lưu Sản Phẩm
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
    .form-control:focus, .form-select:focus {
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
    
    /* Improve select appearance */
    .form-select {
        background-color: var(--bs-dark);
        color: var(--bs-light);
        border: 1px solid var(--bs-secondary);
    }
    .form-select:focus {
        background-color: #1f2937;
        color: #f3f4f6;
    }
    /* Style option dropdown container */
    select option {
        background-color: var(--bs-dark); 
        color: var(--bs-light);
    }
</style>
<script>
    // Preview image before upload
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const container = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        }
    });

    // AJAX Load Attributes by Category
    document.getElementById('category_id').addEventListener('change', function() {
        let categoryId = this.value;
        let attrContainer = document.getElementById('dynamic-attributes-container');
        let variantsContainer = document.getElementById('variants-table-container');
        let tbody = document.getElementById('variants-tbody');
        
        if (!categoryId) {
            attrContainer.innerHTML = '';
            variantsContainer.classList.add('d-none');
            tbody.innerHTML = '';
            return;
        }

        fetch(`/admin/categories/${categoryId}/attributes`)
            .then(response => response.json())
            .then(data => {
                attrContainer.innerHTML = ''; 
                variantsContainer.classList.add('d-none');
                tbody.innerHTML = '';
                
                if (data.length === 0) {
                   attrContainer.innerHTML = '<div class="col-12"><span class="text-warning fst-italic"><i class="bi bi-info-circle me-1"></i>Danh mục này không có thuộc tính phân loại. Sản phẩm sẽ sử dụng giá mặc định ở trên.</span></div>';
                   return;
                }

                data.forEach(attr => {
                    let optionsHtml = attr.values.map(val => 
                        `<option value="${val.attribute_value_id}">${val.value}</option>`
                    ).join('');

                    let html = `
                        <div class="col-md-4 mb-3">
                            <label class="form-label text-info fw-bold">${attr.name}</label>
                            <select class="form-select bg-dark text-light border-secondary attr-select" multiple>
                                ${optionsHtml}
                            </select>
                            <small class="text-secondary" style="font-size:0.75rem;">Giữ Ctrl/Cmd để chọn nhiều</small>
                        </div>
                    `;
                    attrContainer.innerHTML += html;
                });

                document.querySelectorAll('.attr-select').forEach(select => {
                    select.addEventListener('change', generateVariantsTable);
                });
            })
            .catch(err => {
                console.error('Lỗi khi fetch attributes: ', err);
            });
    });

    // Generate Variants Table
    function generateVariantsTable() {
        let allSelected = [];
        document.querySelectorAll('.attr-select').forEach(select => {
            let values = Array.from(select.selectedOptions).map(opt => ({
                id: opt.value, 
                text: opt.text
            }));
            if(values.length > 0) {
                allSelected.push(values);
            }
        });

        let container = document.getElementById('variants-table-container');
        let tbody = document.getElementById('variants-tbody');
        
        if(allSelected.length === 0) {
            container.classList.add('d-none');
            tbody.innerHTML = '';
            return;
        }

        // Tạo mảng tổ hợp (Cartesian product)
        let combinations = allSelected.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [[]]);
        
        let basePrice = document.getElementById('price').value || '';
        let baseStock = document.getElementById('stock').value || '';

        let html = '';
        combinations.forEach((combo, index) => {
            let comboName = combo.map(c => c.text).join(' - ');
            // Generate hidden inputs for the backend to attach Variant & Values
            let hiddenInputs = combo.map(c => `<input type="hidden" name="variants[${index}][attribute_value_ids][]" value="${c.id}">`).join('');
            
            let randomSku = 'PRD-' + Math.random().toString(36).substring(2, 8).toUpperCase();

            html += `
                <tr>
                    <td class="align-middle fw-bold text-info" style="font-size: 0.9rem;">
                        ${comboName}
                        ${hiddenInputs}
                    </td>
                    <td><input type="text" name="variants[${index}][sku]" class="form-control form-control-sm bg-dark text-light border-secondary" value="${randomSku}" required></td>
                    <td><input type="number" name="variants[${index}][price]" class="form-control form-control-sm bg-dark text-light border-secondary" value="${basePrice}" min="0" required></td>
                    <td><input type="number" name="variants[${index}][stock]" class="form-control form-control-sm bg-dark text-light border-secondary" value="${baseStock}" min="0" required></td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        container.classList.remove('d-none');
    }
</script>
@endsection
