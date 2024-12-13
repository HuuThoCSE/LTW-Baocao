<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{

    public function index(){
        $userFarmId = Session::get('farm_id');

        $latestCreatedAt = DB::table('user_owner_farm')
            ->where('farm_id', $userFarmId)
            ->where('role', 'owner')
            ->max('created_at'); // Lấy thời gian created_at mới nhất trong bảng user_owner_farm

//        dd($userFarmId);

        $excludedUserIds = DB::table('user_owner_farm')
            ->where('farm_id', $userFarmId)
            ->where('created_at', $latestCreatedAt) // Chỉ lấy các user_id có created_at mới nhất
            ->pluck('user_id'); // Lấy danh sách user_id cần loại trừ

        $users = DB::table('users')
            ->where('user_id', '!=', 1) // Bỏ qua tài khoản có id = 1
            ->where('farm_id', $userFarmId) // Chỉ lấy tài khoản có farm_id bằng với session user_farm_id
            ->whereNotIn('user_id', $excludedUserIds) // Loại trừ các user_id trong danh sách
            ->get();

//        $users = DB::table('users')
//            ->where('user_id', '!=', 1) // Bỏ qua tài khoản có id = 1
//            ->where('farm_id', $userFarmId) // Chỉ lấy tài khoản có farm_id bằng với session user_farm_id
//            ->get();

        // Fetch roles for the dropdown list, only roles with ID 3, 4, 5
//        $adminFarmId = auth()->user()->farm_id;
        $roles = DB::table('farm_roles')
            ->whereIn('role_id', [3, 4, 5])  // Lọc các role_id 3, 4, 5
            ->get();
        // Truyền cả người dùng và vai trò vào view
        return view('account.index', ['users' => $users, 'farm_roles' => $roles]);

    }
    public function del($user_id)
    {
        // Find the medication by ID and delete it
        $account = DB::table('users')->where('user_id', $user_id);

        if ($account->exists()) {
            $account->delete();
            return redirect()->back()->with('success', 'Medication deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Medication not found.');
        }
    }
    public function add(Request $request){
        $farm_id = session('farm_id');

        // Lấy tất cả người dùng
        $users = DB::table('users')->get();

        // Lấy danh sách các role có role_id là 3, 4, 5
        $roles = DB::table('farm_roles')
                ->whereIn('role_id', [3, 4, 5])  // Lọc các role_id 3, 4, 5
                ->get();

//        dd($request);

        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|string|max:255',
            'user_email' => [
                'required',
                'email',
                'unique:users,user_email', // Kiểm tra tính duy nhất
                // Thêm validation regex cho emails có dạng name@farm.farm_id.com
//                'regex:/^[a-zA-Z0-9._%+-]+@farm(\d+)\.vn$/', // Dùng (\d+) để kiểm tra farm_id không dùng .(\d+)
            ],
            'user_password' => 'required|string|min:6',
            'role_id' => 'required|in:3,4,5',  // Kiểm tra role_id phải là 3, 4 hoặc 5
        ], [
            'role_id.in' => 'Role ID phải là 3, 4 hoặc 5.',
            'user_email.unique' => 'Email này đã được đăng ký.',
            'user_email.regex' => 'Email phải có dạng name@farm(farm_id).vn.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Thêm tài khoản vào cơ sở dữ liệu
        DB::table('users')->insert([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => bcrypt($request->user_password),
            'role_id' => $request->role_id, // Chọn role_id từ dropdown
            'farm_id' => $farm_id, // Lấy farm_id từ session
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Truyền các role và users vào view
        return redirect()->route('account.index')->with('success', 'User added successfully.');
    }


    public function udp(Request $request, $user_id)
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

    public function show($id)
    {
        // Lấy thông tin người dùng và vai trò của họ
        $user = DB::table('users')
            ->join('farms', 'users.farm_id', '=', 'farms.farm_id')
            ->join('farm_roles', 'users.role_id', '=', 'farm_roles.role_id') // Kết nối với bảng roles
            ->select('users.*', 'farms.farm_name', 'farm_roles.role_name') // Chọn tên vai trò
            ->where('users.user_id', $id)
            ->first();

        if (!$user) {
            return redirect()->route('home')->with('error', 'Account not found.');
        }

        return view('account.show', ['user' => $user]); // Đảm bảo tên file view là `showAccount.blade.php`
    }

    public function getOwners()
    {
        // Lọc người dùng là owner farm
        return response()->json(
            User::where('role_id', 2)->get(['user_id', 'user_name'])
        );
    }
}
