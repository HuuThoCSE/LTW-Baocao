<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FarmModel;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function getView()
    {
        return view('login', []);
    }

    protected function storeSessionData($user) {
        Session::put('user_id', $user->user_id);
        Session::put('user_role_id', $user->role_id);
        Session::put('farm_id', $user->farm_id);

        $farm = FarmModel::where('farm_id', $user->farm_id)->first();

        if ($farm) {
            Session::put('farm_name', $farm->farm_name);
        } else {
            // Xử lý trường hợp không tìm thấy farm, ví dụ lưu giá trị mặc định
            Session::put('farm_name', 'Unknown Farm');
        }
    }

    public function login(Request $request)
    {
        $user_email = $request->input('email');
        $password = $request->input('password');


        // Truy vấn cơ sở dữ liệu để lấy user theo emails
        $user = DB::table('users')->where('user_email', $user_email)->first();


        // Kiểm tra xem user có tồn tại và mật khẩu có khớp không
        if ($user && Hash::check($password, $user->user_password)) {

            LogModel::create([
                'user_id' => $user->user_id,  // Giá trị từ đối tượng $user
                'description' => $user->user_name.' (ID: '.$user->user_id.') - Login'
            ]);

            Auth::loginUsingId($user->user_id);

            $this->storeSessionData($user);

            // Lấy quyền của người dùng từ bảng user_permissions
            $userPermissions = DB::table('user_permissions')
                ->where('user_id', $user->user_id)
                ->pluck('permission_id')
                ->toArray();

            // Lưu quyền vào session
            Session::put('permissions', $userPermissions);

            switch (Auth::user()->role_id) { // Dùng 'name' trong bảng roles để phân biệt quyền
                case 1:
                    Session::put('account_perm', 'admin');
                    // Quản trị viên
//                    return view('main-admin')->with('layout', 'main-admin');
                    return redirect()->route('home');
                case 2:
                    Session::put('account_perm', 'owner');
                    // return view('main')->with('layout', 'main');
                    return redirect()->route('home');
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
            // Nếu đăng nhập thất bại, trả lại thông báo lỗi
            return back()->withErrors(['emails' => 'Thông tin đăng nhập không chính xác.']);
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
