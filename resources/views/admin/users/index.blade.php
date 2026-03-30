@extends('layouts.master')

@section('title', 'Quản Lý Tài Khoản - ElectroGear')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="text-white fw-bold"><i class="bi bi-people-fill me-2 text-laravel"></i>Hồ Sơ Điện Tử (Users)</h4>
        <p class="text-secondary mb-0">Quản lý phân quyền và trạng thái khách hàng</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success bg-dark-custom text-success border-success mb-4 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger bg-dark-custom text-danger border-danger mb-4 d-flex align-items-center">
    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
    <div>{{ session('error') }}</div>
</div>
@endif

<div class="card bg-dark-custom border-secondary shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="60" class="text-center">ID</th>
                        <th>Thông Tin Cấp Cơ Sở</th>
                        <th>Liên Hệ</th>
                        <th width="120" class="text-center">Cấp Bậc</th>
                        <th width="140" class="text-center">Trạng Thái</th>
                        <th width="140" class="text-center">Điều Chỉnh</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($users as $user)
                    <tr>
                        <!-- ID -->
                        <td class="text-center text-secondary">#{{ $user->user_id }}</td>
                        
                        <!-- Thông tin -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                    {{ mb_substr($user->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <strong class="text-white d-block mb-1">{{ $user->full_name }}</strong>
                                    <span class="text-secondary small"><i class="bi bi-clock me-1"></i>Đăng ký: {{ $user->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Liên hệ -->
                        <td>
                            <div class="text-light small mb-1"><i class="bi bi-envelope text-secondary me-2"></i>{{ $user->email }}</div>
                            <div class="text-secondary small"><i class="bi bi-telephone me-2"></i>{{ $user->phone_number ?? 'Chưa cập nhật' }}</div>
                        </td>
                        
                        <!-- Quyền -->
                        <td class="text-center">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2 py-1"><i class="bi bi-shield-lock-fill me-1"></i>Quản trị (Admin)</span>
                            @else
                                <span class="badge bg-info-subtle text-info border border-info border-opacity-25 px-2 py-1"><i class="bi bi-person-fill me-1"></i>Khách hàng</span>
                            @endif
                        </td>
                        
                        <!-- Trạng thái -->
                        <td class="text-center">
                            @if($user->status === 'active')
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-circle-fill small me-1" style="font-size: 8px;"></i>Bình thường</span>
                            @else
                                <span class="badge bg-secondary text-light border border-secondary border-opacity-50 px-2 py-1"><i class="bi bi-slash-circle me-1"></i>Bị khóa</span>
                            @endif
                        </td>
                        
                        <!-- Hành động -->
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <!-- Nút Thăng/Giáng chức -->
                                <form action="{{ route('users.toggle-role', $user->user_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-dark border-secondary {{ $user->role === 'admin' ? 'text-info hover-glow-info' : 'text-danger hover-glow-danger' }}" title="{{ $user->role === 'admin' ? 'Giáng chức xuống Khách hàng' : 'Thăng cấp Quản trị viên' }}" {{ $user->user_id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi {{ $user->role === 'admin' ? 'bi-arrow-down-square-fill' : 'bi-arrow-up-square-fill' }}"></i>
                                    </button>
                                </form>

                                <!-- Nút Đình chỉ / Mở khóa -->
                                <form action="{{ route('users.toggle-status', $user->user_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-dark border-secondary {{ $user->status === 'active' ? 'text-secondary hover-glow-warning' : 'text-success hover-glow-success' }}" title="{{ $user->status === 'active' ? 'Đình chỉ mỏ' : 'Ân xá mở khóa' }}" {{ $user->user_id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi {{ $user->status === 'active' ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                    </button>
                                </form>

                                <!-- Nút Xóa -->
                                <form action="{{ route('users.destroy', $user->user_id) }}" method="POST" class="d-inline" onsubmit="return confirm('CẢNH BÁO MẤT DỮ LIỆU!\nBạn có chắn chắn muốn xóa VĨNH VIỄN tài khoản {{ $user->full_name }} không? Hành động này không thể hoàn tác!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-dark border-secondary text-danger hover-glow-danger" title="Xóa tài khoản" {{ $user->user_id === Auth::id() ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="bi bi-people fs-1 text-secondary d-block mb-3 opacity-50"></i>
                            <h5 class="text-secondary fw-bold">Không Có Người Dùng</h5>
                            <p class="text-muted">Hệ thống của bạn chưa có sinh linh nào tồn tại.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Phân trang -->
    @if($users->hasPages())
    <div class="card-footer border-secondary bg-transparent pt-3 pb-3 text-center d-flex justify-content-center">
         {{ $users->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<style>
    /* Table Dark Theme */
    .table-dark {
        --bs-table-bg: transparent;
        --bs-table-striped-bg: rgba(255, 255, 255, 0.02);
        --bs-table-border-color: #374151;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.05);
    }
    .table > :not(caption) > * > * {
        padding: 1.25rem 0.75rem;
    }
    
    /* Hiệu ứng Glow cho Action Buttons */
    .hover-glow-success:hover { box-shadow: 0 0 10px rgba(25, 135, 84, 0.5); border-color: #198754 !important; color: #198754 !important; }
    .hover-glow-info:hover { box-shadow: 0 0 10px rgba(13, 202, 240, 0.5); border-color: #0dcaf0 !important; color: #0dcaf0 !important; }
    .hover-glow-warning:hover { box-shadow: 0 0 10px rgba(255, 193, 7, 0.5); border-color: #ffc107 !important; color: #ffc107 !important; }
    .hover-glow-danger:hover { box-shadow: 0 0 10px rgba(220, 53, 69, 0.5); border-color: #dc3545 !important; background-color: transparent !important; color: #dc3545 !important;}
    
    button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* CSS Pagination */
    .pagination { margin-bottom: 0; }
    .page-link { 
        background-color: var(--dark-surface);
        border-color: #374151;
        color: var(--text-light);
    }
    .page-link:hover {
        background-color: #374151;
        color: white;
        border-color: #4b5563;
    }
    .page-item.active .page-link {
        background-color: var(--laravel-red);
        border-color: var(--laravel-red);
        color: white;
        box-shadow: 0 0 10px rgba(255, 45, 32, 0.5);
    }
    .page-item.disabled .page-link {
        background-color: var(--darker-bg);
        border-color: #374151;
        color: #6b7280;
    }
</style>
@endsection
