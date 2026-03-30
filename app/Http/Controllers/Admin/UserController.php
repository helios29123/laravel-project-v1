<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle user role between admin and customer.
     */
    public function toggleRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ngăn không cho tự giáng chức chính mình
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Không thể tự thay đổi quyền của chính mình!');
        }

        $user->role = $user->role === 'admin' ? 'customer' : 'admin';
        $user->save();

        return redirect()->route('users.index')->with('success', 'Đã cập nhật quyền hạn cho tài khoản ' . $user->full_name);
    }

    /**
     * Toggle user status between active and inactive.
     */
    public function toggleStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Ngăn không cho khóa chính mình
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Không thể tự khóa tài khoản của chính mình!');
        }

        // Tự động chặn nếu đang cố khóa super-admin (giả định role admin là không thể bị khóa bởi người khác)
        // Nếu dự án có nhiều admin và có thể khóa nhau thì bỏ phần này.
        if ($user->isAdmin() && Auth::id() !== 1) { // Chỉ user_id = 1 mới có quyền khóa admin khác (tuỳ chọn)
            return redirect()->back()->with('error', 'Không có quyền khóa một quản trị viên khác!');
        }

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        $action = $user->status === 'active' ? 'Mở khóa' : 'Khóa';
        return redirect()->route('users.index')->with('success', 'Đã ' . $action . ' tài khoản ' . $user->full_name);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Ngăn không cho tự xóa chính mình
        if ($user->user_id === Auth::id()) {
            return redirect()->back()->with('error', 'Không thể tự xóa tài khoản của chính mình!');
        }

        // Kiểm tra ràng buộc khoá ngoại trước khi xóa (ví dụ order, cart) => Đáng lẽ CSDL có cascade delete
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Đã xóa vĩnh viễn tài khoản ' . $user->full_name);
    }
}
