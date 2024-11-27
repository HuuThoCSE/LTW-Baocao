<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    
    public function getView()
    {
        $users = DB::table('users')->get();
        return view('account',['users' => $users]);
    }
    public function delAccount($id)
    {
        // Find the medication by ID and delete it
        $account = DB::table('users')->where('id', $id);
        
        if ($account->exists()) {
            $account->delete();
            return redirect()->back()->with('success', 'Medication deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Medication not found.');
        }
    }
    public function addUser(Request $request)
{
    // Debugging: Check all request data
    $name = $request->input('name');
    $email = $request->input('email');
    $password = $request->input('password');
    $farm_id = $request->input('farm_id');
    $role_id = $request->input('role_id'); // Lấy role_id từ request

    // Validate farm_id exists in farms table
    $farmExists = DB::table('farms')->where('farm_id', $farm_id)->exists();

    // Kiểm tra nếu farm_id không hợp lệ
    if (!$farmExists) {
        return redirect()->back()->withErrors(['farm_id' => 'Farm ID không tồn tại'])->withInput();
    }

    // Validate email không trùng lặp
    $emailExists = DB::table('users')->where('email', $email)->exists();
    if ($emailExists) {
        return redirect()->back()->withErrors(['email' => 'Email này đã được đăng ký'])->withInput();
    }

    // Kiểm tra role_id có hợp lệ không (tức là tồn tại trong bảng roles)
    $roleExists = DB::table('roles')->where('id', $role_id)->exists();
    if (!$roleExists) {
        return redirect()->back()->withErrors(['role_id' => 'Role ID không tồn tại'])->withInput();
    }

    // Mã hóa mật khẩu
    $password = Hash::make($password);

    // Insert vào bảng users
    DB::table('users')->insert([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'farm_id' => $farm_id,
        'role_id' => $role_id, // Thêm role_id vào bảng users
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Lấy danh sách người dùng và trả về view
    $users = DB::table('users')->get();
    return view('account', ['users' => $users]);
}


public function udpAcc(Request $request, $id)
{
    // Lấy các thông tin cần cập nhật
    $name = $request->input('name');
    $email = $request->input('email');
    $password = $request->input('password');
    $farm_id = $request->input('farm_id');
    $role_id = $request->input('role_id'); // Lấy role_id từ request

    // Kiểm tra role_id có hợp lệ không
    $roleExists = DB::table('roles')->where('id', $role_id)->exists();
    if (!$roleExists) {
        return redirect()->back()->withErrors(['role_id' => 'Role ID không tồn tại'])->withInput();
    }

    // Mã hóa mật khẩu nếu có thay đổi
    if ($password) {
        $password = Hash::make($password);
    }

    // Cập nhật thông tin người dùng
    DB::table('users')->where('id', $id)->update([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'farm_id' => $farm_id,
        'role_id' => $role_id, // Cập nhật role_id
    ]);

    // Lấy danh sách người dùng và trả về view
    $users = DB::table('users')->get();
    return redirect()->route('account')->with('success', 'Account updated successfully.');
}

public function showAccount($id)
{
    // Lấy thông tin người dùng và vai trò của họ
    $user = DB::table('users')
        ->join('farms', 'users.farm_id', '=', 'farms.farm_id')
        ->join('roles', 'users.role_id', '=', 'roles.id') // Kết nối với bảng roles
        ->select('users.*', 'farms.farm_name', 'roles.name as role_name') // Chọn tên vai trò
        ->where('users.id', $id)
        ->first();

    if (!$user) {
        return redirect()->route('home')->with('error', 'Account not found.');
    }

    return view('account.show', ['user' => $user]); // Đảm bảo tên file view là `showAccount.blade.php`
}



}
