<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('emails', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'emails' => 'Thông tin đăng nhập không chính xác',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush(); // Xóa tất cả dữ liệu trong session

        return redirect()->route('login');
    }
}
