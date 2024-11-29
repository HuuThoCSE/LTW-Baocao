<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class ListFarmController extends Controller
{
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $farms = DB::table('farms')->get(); // Thực hiện truy vấn để lấy dữ liệu
        // Truyền dữ liệu vào view
        return view('farm/dashboard', ['farms' => $farms]);
    }

    public function addFarm(Request $request)
{
    // Kiểm tra lỗi khi ô bị bỏ trống
    $request->validate([
        'farm_name' => 'required|string|max:255',
        'location' => 'required|string',
        'owner_id' => 'required|integer',
    ]);

    // Lấy dữ liệu từ request
    $farm_name = $request->input('farm_name');
    $location = $request->input('location');
    $owner_id = $request->input('owner_id');

    // Insert farm vào cơ sở dữ liệu
    $farm_id = DB::table('farms')->insertGetId([
        'farm_name' => $farm_name,
        'location' => $location,
        'owner_id' => $owner_id,
    ]);

    // Kiểm tra nếu checkbox "Tạo tài khoản admin" được chọn
    if ($request->has('create_admin')) {
        $adminEmail = 'admin@farm.' . $farm_id . '.com';
        $user_password = '123456'; // Mật khẩu cụ thể cho tài khoản admin

        // Tạo tài khoản admin
        DB::table('users')->insert([
            'user_name' => 'Admin farm ' . $farm_id, // Tạo tên admin với farm_id
            'user_email' => $adminEmail,
            'user_password' => Hash::make($user_password), // Mật khẩu mặc định
            'role_id' => '2', // Quyền admin
            'farm_id' => $farm_id,
        ]);
        
    }

    // Chuyển hướng về danh sách farm với thông báo thành công
    return redirect()->route('listfarm')->with('success', 'Farm added successfully.');
}




    public function delFarm($farm_id)
    {
        // Find the medication by ID and delete it
        $farm = DB::table('farms')->where('farm_id', $farm_id);
        
        if ($farm->exists()) {
            $farm->delete();
            return redirect()->back()->with('success', 'Farm deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Farm not found.');
        }
    }

    public function udpFarm(Request $request, $farm_id)
    {
        // Update medicaion
        $farm_name = $request->input('farm_name');
        $location = $request->input('location');
        $owner_id = $request->input('owner_id');

        DB::table('farms')->where('farm_id', $farm_id)->update([
            'farm_name'=>$farm_name ,
            'location'=>$location,
            'owner_id'=>$owner_id]);

        $farms = DB::table('farms')->get();
        // return view('farm/dashboard',['farms' => $farms]);
        return redirect()->route('listfarm')->with('success', 'Farm updated successfully.');
    }
}
