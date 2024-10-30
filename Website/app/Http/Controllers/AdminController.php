<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    public function getView()
    {
        $users = DB::table('users')->get();
        return view('admin',['users' => $users]);
    }
    public function addUser(Request $request)
    {
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $password= $request->input('password');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8', // Mật khẩu tối thiểu 8 ký tự
                'confirmed', // Kiểm tra xem trường password_confirmation có trùng khớp hay không
                'regex:/[a-z]/', // Ít nhất một ký tự chữ cái thường
                'regex:/[A-Z]/', // Ít nhất một ký tự chữ cái hoa
                'regex:/[0-9]/', // Ít nhất một ký tự số
                'regex:/[@$!%*?&]/', // Ít nhất một ký tự đặc biệt
            ],
        ]);

        $password = Hash::make($request->input('password'));

        // Insert to database
        DB::table('users')->insert([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $users = DB::table('users')->get();
        return view('admin',['users' => $users]);
    }
}


