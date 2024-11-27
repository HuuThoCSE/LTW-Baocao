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

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Truy vấn cơ sở dữ liệu để lấy user theo email
        $account = DB::table('users')->where('email', $email)->first();

        // Kiểm tra xem user có tồn tại và mật khẩu có khớp không
        if ($account && Hash::check($password, $account->password)) {

            // Mật khẩu đúng, lấy quyền từ bảng roles thông qua role_id của user
            $role = DB::table('roles')->where('role_id', $account->role_id)->first();

            // Lưu farm_id và role_id (farm_perm) vào session
            Session::put('farm_id', $account->farm_id);

            if ($role) {
                // Kiểm tra quyền của người dùng
                switch ($role->name) { // Dùng 'name' trong bảng roles để phân biệt quyền
                    case 1:
                        Session::put('account_perm', 'admin');
                        // Quản trị viên
                        return view('main-admin')->with('layout', 'main-admin');
                    case 2:
                        Session::put('account_perm', 'owner');
                        return view('main')->with('layout', 'main');
                    case 3:
                        Session::put('account_perm', 'it');
                        // IT
                        return redirect()->route('home');
                    case 4:
                        Session::put('account_perm', 'farmer');
                        // Nông dân
                        return redirect()->route('home');
                    case 5:
                        Session::put('account_perm', 'customer');
                        // Khách hàng
                        return redirect()->route('home');
                    default:
                        return back()->withErrors([
                            'username' => 'Không có quyền truy cập.',
                        ]);
                }
            } else {
                return 'Tài khoản không có quyền.';
                // return back()->withErrors([
                //     'username' => 'Tài khoản không có quyền.',
                // ]);
            }
           
        } else {
            return 'Thông tin đăng nhập không chính xác.';
            // Sai username hoặc password
            // return back()->withErrors([
            //     'username' => 'Thông tin đăng nhập không chính xác.',
            // ]);
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
