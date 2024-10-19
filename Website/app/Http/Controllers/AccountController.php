<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function getView()
    {
        return view('account',[]);
    }
    public function index()
    {
        $users = User::all(); // Lấy tất cả tài khoản từ bảng users
        return view('users.index', compact('users')); // Trả về view và truyền dữ liệu
    }
}
