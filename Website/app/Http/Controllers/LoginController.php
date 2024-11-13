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
            // Mật khẩu đúng, lấy quyền từ bảng roles
            $role = DB::table('roles')->where('user_id', $user->id)->first();

            $farm_id = $user->farm_id;
            session(['encrypted_farm_id' => encrypt($farm_id)]);

            // $farm_id = decrypt(session('encrypted_farm_id'));

            if ($role) {
                // Kiểm tra quyền của người dùng
                switch ($role->role) {
                    case 0:
                        // Quản trị viên
                        return redirect()->route('home');
                    case 1:
                        // Admin
                        return redirect()->route('home');
                    case 2:
                        // Nông dân
                        return redirect()->route('home');
                    case 3:
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
        $role = DB::table('roles')->where('user_id', $user->id)->first();

        return view('home', [
            'role' => $role ? $role->role : null,
            'userName' => $user->name, // Truyền tên người dùng vào view
        ]);
    }
    

}
