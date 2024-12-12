<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\FarmNotificationMail;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class FarmController extends Controller
{
    public function index()
    {
        // Lấy danh sách từ bảng 'farms'
        $farms = DB::table('farms')->get(); // Thực hiện truy vấn để lấy dữ liệu

        // Truyền dữ liệu vào view
        return view('farms.index', ['farms' => $farms]);
    }

    public function add(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'farm_name' => 'required|string|max:255',
            'location' => 'required|string',
            'chb_old_owner' => 'in:on,off',  // Chỉ chấp nhận giá trị on hoặc off
            'sel_owner_id' => 'nullable|integer', // Không bắt buộc nếu tạo owner mới
            'inp_email' => 'required|email', // Email của user
        ]);

        // Lấy dữ liệu
        $farm_name = $validatedData['farm_name'];
        $location = $validatedData['location'];
        $chb_old_owner = $validatedData['chb_old_owner'] ?? 'off'; // Giá trị mặc định là "off"
        $user_email = $validatedData['inp_email'];

        // Tạo farm trước
        $farm_id = DB::table('farms')->insertGetId([
            'farm_name' => $farm_name,
            'location' => $location,
        ]);

        $user_name = 'Owner of FarmModel ' . $farm_name;
        $user_email_new = 'owner@farm'.$farm_id.'.vn';
        $user_password = '123456'; // Mật khẩu mặc định

        // Xử lý logic: Nếu checkbox không được chọn -> Tạo tài khoản owner mới
        if ($chb_old_owner === 'off') {
            // Tạo tài khoản owner mới
            $owner_id = DB::table('users')->insertGetId([
                'user_name' =>  $user_name,
                'user_email' => $user_email_new,
                'user_password' => Hash::make($user_password), // Mật khẩu mặc định
                'role_id' => 2, // Quyền owner
                'farm_id' => $farm_id, // Liên kết owner với farm vừa tạo
            ]);
        } else {
            // Nếu checkbox được chọn -> Lấy owner_id từ request
            $owner_id = $validatedData['sel_owner_id'];

            if (!$owner_id) {
                return response()->json([
                    'message' => 'Owner is required if "Owner đã có farm" is selected.',
                ], 422); // Trả lỗi nếu không có owner_id
            }
        }

        // Thêm dữ liệu vào bảng user_owner_farm
        DB::table('user_owner_farm')->insert([
            'user_id' => $owner_id,
            'farm_id' => $farm_id,
            'role' => 'owner', // Vai trò mặc định là chủ sở hữu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Thông tin cần gửi qua email
        $userDetails = [
            'user_name' => $user_name,
            'user_email' => $user_email_new,
            'user_password' => $user_password, // Mật khẩu mặc định (hoặc đã tạo)
        ];

        // Gửi email
        Mail::to($user_email)->send(new FarmNotificationMail($userDetails));

        $user_id = Auth::user()->user_id;

        LogModel::create([
            'user_id' => $user_id,  // Giá trị từ đối tượng $user
            'description' => "User with ID {$user_id} created a FarmModel named '{$farm_name}' successfully."
        ]);

        return response()->json([
            'message' => 'FarmModel added successfully!',
            'farm_id' => $farm_id,
            'owner_id' => $owner_id,
        ]);
    }


    public function del($farm_id)
    {
        // Find the medication by ID and delete it
        $farm = DB::table('farms')->where('farm_id', $farm_id);

        if ($farm->exists()) {
            $farm->delete();
            return redirect()->back()->with('success', 'FarmModel deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'FarmModel not found.');
        }
    }

    public function udp(Request $request, $farm_id)
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
        return redirect()->route('listfarm')->with('success', 'FarmModel updated successfully.');
    }

    public function show($id)
    {
        $farm = DB::table('farms')->where('id', $id)->first(); // Lấy farm theo id
        if (!$farm) {
            abort(404, 'FarmModel not found'); // Nếu không tìm thấy farm
        }
        return view('farms.show', compact('farm'));
    }
}
