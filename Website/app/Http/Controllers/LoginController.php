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
        return view('login',[]);
    }

    public function login(Request $request)
    {
        // dd($request);

        $username = $request->input('username');
        $password = $request->input(    'password');

        // Truy vấn cơ sở dữ liệu để lấy user theo username
        $user = DB::table('users')->where('username', $username)->first();

        // Kiểm tra xem user có tồn tại và mật khẩu có khớp không
        if ($user && Hash::check($password, $user->password)) {
            // Mật khẩu đúng, đăng nhập thành công
            return "Login successful!";
        } else {
            // Sai username hoặc password
            return "Invalid username or password!";
        }
    }

}
