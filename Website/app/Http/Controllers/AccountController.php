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
    $user_name = $request->input('user_name');
    $user_email = $request->input('user_email');
    $user_password = $request->input('user_password');
    $farm_id = $request->input('farm_id');
    $role_id = $request->input('role_id'); // Lấy role_id từ request

    // Mã hóa mật khẩu
    $user_password = Hash::make($user_password);

    // Insert vào bảng users
    DB::table('users')->insert([
        'user_name' => $user_name,
        'user_email' => $user_email,
        'user_password' => $user_password,
        'farm_id' => $farm_id,
        'role_id' => $role_id, // Thêm role_id vào bảng users
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    // Lấy danh sách người dùng và trả về view
    $users = DB::table('users')->get();
    dd($user_name, $user_email, $user_password, $farm_id, $role_id);

    return view('account', ['users' => $users]);
}


public function udpAcc(Request $request, $user_id)
{
    // Lấy các thông tin cần cập nhật
    $user_name = $request->input('user_name');
    $user_email = $request->input('user_email');
    $user_password = $request->input('user_password');
    $farm_id = $request->input('farm_id');
    $role_id = $request->input('role_id'); // Lấy role_id từ request

    // Kiểm tra role_id có hợp lệ không
    $roleExists = DB::table('roles')->where('role_id', $role_id)->exists();
    if (!$roleExists) {
        return redirect()->back()->withErrors(['role_id' => 'Role ID không tồn tại'])->withInput();
    }

    // Mã hóa mật khẩu nếu có thay đổi
    if ($user_password) {
        $user_password = Hash::make($user_password);
    }

    // Cập nhật thông tin người dùng
    DB::table('users')->where('id', $user_id)->update([
        'user_name' => $user_name,
        'user_email' => $user_email,
        'user_password' => $user_password,
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
