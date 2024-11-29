<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function getView()
    {
        return view('login', []);
    }

    protected function storeSessionData($user) {
        Session::put('user_id', $user->user_id);
        Session::put('user_role', $user->role_id);
        Session::put('user_farm_id', $user->farm_id);
    }

    public function login(Request $request)
    {
        $user_email = $request->input('email');
        $password = $request->input('password');

        // Truy vấn cơ sở dữ liệu để lấy user theo email
        $user = DB::table('users')->where('user_email', $user_email)->first();

        // Kiểm tra xem user có tồn tại và mật khẩu có khớp không
        if ($user && Hash::check($password, $user->user_password)) {

            // Lấy quyền của người dùng từ bảng user_permissions
            $userPermissions = DB::table('user_permissions')
                ->where('user_id', $user->user_id)
                ->pluck('permission_id')
                ->toArray();

            // Lưu quyền vào session
            Session::put('permissions', $userPermissions);

            // Truy vấn bảng farm_role để lấy role_name dựa trên role_id
            $role = DB::table('farm_roles')->where('role_id', $user->role_id)->first();

            // Kiểm tra xem có role_name hay không
            if ($role) {
                // Lưu role_name vào session
                Session::put('role_name', $role->role_name);
            } else {
                // Xử lý trường hợp không tìm thấy role_name
                Session::put('role_name', 'Role not found');
            }

            // Lưu thông tin user vào session
            Session::put('user_id', $user->user_id);

            // Chuyển hướng dựa vào role_id
            switch ($user->role_id) {
                case 1: // Administrator
                    return redirect()->route('administrator.dashboard');
                case 2: // Admin
                    return redirect()->route('admin.dashboard');
                case 3: // IT
                    return redirect()->route('home');
                default:
                    return redirect()->route('home');
            }
        } else {
            // Nếu đăng nhập thất bại, trả lại thông báo lỗi
            return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác.']);
        }
    }


    public function index(Request $request)
    {
        $user = $request->user(); // Lấy thông tin người dùng đã đăng nhập
        $role = DB::table('roles')->where('id', $user->role_id)->first();

        return view('home', [
            'role' => $role ? $role->name : null,  // Lấy tên role thay vì id
            'userName' => $user->name, // Truyền tên người dùng vào view
        ]);
    }
}
