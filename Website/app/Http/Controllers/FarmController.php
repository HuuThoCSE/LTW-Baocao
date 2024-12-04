<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class FarmController extends Controller
{
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $farms = DB::table('farms')->get(); // Thực hiện truy vấn để lấy dữ liệu
        // Truyền dữ liệu vào view
        return view('farm.dashboard', ['farms' => $farms]);
    }

    public function addFarm(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'farm_name' => 'required|string|max:255',
            'location' => 'required|string',
            'chb_old_owner' => 'in:on,off',  // Chỉ chấp nhận giá trị on hoặc off
            'sel_owner_id' => 'nullable|integer', // Không bắt buộc nếu tạo owner mới
        ]);

        // Lấy dữ liệu
        $farm_name = $validatedData['farm_name'];
        $location = $validatedData['location'];
        $chb_old_owner = $validatedData['chb_old_owner'] ?? 'off'; // Giá trị mặc định là "off"

        // Tạo farm trước
        $farm_id = DB::table('farms')->insertGetId([
            'farm_name' => $farm_name,
            'location' => $location,
            'owner_id' => null, // Chủ sở hữu sẽ được cập nhật sau
        ]);

        // Xử lý logic: Nếu checkbox không được chọn -> Tạo tài khoản owner mới
        if ($chb_old_owner === 'off') {
            // Tạo tài khoản owner mới
            $owner_id = DB::table('users')->insertGetId([
                'user_name' => 'Owner of Farm ' . $farm_name,
                'user_email' => 'owner' . strtolower(str_replace(' ', '_', $farm_name)) . '@farm.com',
                'user_password' => Hash::make('123456'), // Mật khẩu mặc định
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

            // Cập nhật owner_id cho farm vừa tạo
            DB::table('farms')->where('id', $farm_id)->update(['owner_id' => $owner_id]);
        }

        return response()->json([
            'message' => 'Farm added successfully!',
            'farm_id' => $farm_id,
            'owner_id' => $owner_id,
        ]);
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

    public function show($id)
    {
        $farm = DB::table('farms')->where('id', $id)->first(); // Lấy farm theo id
        if (!$farm) {
            abort(404, 'Farm not found'); // Nếu không tìm thấy farm
        }
        return view('farms.show', compact('farm'));
    }
}
