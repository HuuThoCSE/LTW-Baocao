<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getView()
    {
        return view('login', []);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Truy vấn cơ sở dữ liệu để lấy user theo email
        $user = DB::table('users')->where('email', $username)->first();

        // Kiểm tra xem user có tồn tại và mật khẩu có khớp không
        if ($user && Hash::check($password, $user->password)) {
            // Mật khẩu đúng, lấy quyền từ bảng roles thông qua role_id của user
            $role = DB::table('roles')->where('id', $user->role_id)->first();

            if ($role) {
                // Kiểm tra quyền của người dùng
                switch ($role->name) { // Dùng 'name' trong bảng roles để phân biệt quyền
                    case 'admin':
                        // Quản trị viên
                        return view('admin.dashboard')->with('layout', 'main-admin');
                    case 'moderator':
                        // Admin
                        return view('admin.dashboard')->with('layout', 'main');
                    case 'farmer':
                        // Nông dân
                        return redirect()->route('home');
                    case 'customer':
                        // Khách hàng
                        return redirect()->route('home');
                    default:
                        return back()->withErrors([
                            'username' => 'Không có quyền truy cập.',
                        ]);
                }
                
            } else {
                return back()->withErrors([
                    'username' => 'Tài khoản không có quyền.',
                ]);
            }
           
        } else {
            // Sai username hoặc password
            return back()->withErrors([
                'username' => 'Thông tin đăng nhập không chính xác.',
            ]);
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
