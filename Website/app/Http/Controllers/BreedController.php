<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\BreedModel;

class BreedController extends Controller
{
    public function index()
    {
        // if(empty(Session::get('user_farm_id'))){
        //     return redirect()->route('login');
        // }

        $breeds = DB::table('farm_breeds')
            ->where('farm_id', Session::get('farm_id'))
            ->get();
        return view('breeds.index', ['breeds' => $breeds]);
    }

    public function add(Request $request)
    {

//         dd($request->all());

        // Validate input
        $request->validate([
            'breed_name_eng' => 'required|string|max:255',
            'breed_name_vie' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',  // Optional field
        ]);


        try {
            // Insert the new breed into the database
            DB::table('farm_breeds')->insert([
                'breed_name_eng' => $request->breed_name_eng,  // Input from form
                'breed_name_vie' => $request->breed_name_vie,  // Input from form
                'description' => $request->description,        // Input from form
                'farm_id' => Session::get('farm_id'),                         // FarmModel ID from session
            ]);

            // Return success message and redirect
            return redirect()->route('breeds.index')->with('success', 'BreedModel added successfully');
        } catch (\Exception $e) {
            // LogModel the error for debugging
            Log::error('Error inserting breed: ' . $e->getMessage());

            // Return error message and redirect
            return redirect()->route('breeds.index')->with('error', 'Failed to add breed. Please try again.');
        }
    }

    public function udp(Request $request, $id)
    {
        // Kiểm tra và xác nhận dữ liệu nhập vào
        $request->validate([
            'breed_name_eng' => 'required|string|max:255',
            'breed_name_vie' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Tìm giống (breed) theo ID
        $breed = BreedModel::find($id);

        // Kiểm tra xem giống có tồn tại hay không
        if (!$breed) {
            return redirect()->route('breeds.index')->with('error', 'BreedModel not found.');
        }

        // Cập nhật thông tin giống
        $breed->breed_name_eng = $request->breed_name_eng;
        $breed->breed_name_vie = $request->breed_name_vie;
        $breed->description = $request->description;

        // Lưu thay đổi vào cơ sở dữ liệu
        $breed->save();

        // Quay lại với thông báo thành công
        return redirect()->route('breeds.index')->with('success', 'BreedModel updated successfully.');
    }

    // Delete a breed
    public function del($id)
    {
        try {
            // Tìm breed theo ID
            $breed = BreedModel::find($id);

            // Kiểm tra nếu không tìm thấy breed
            if (!$breed) {
                return redirect()->back()->with('error', 'BreedModel not found.');
            }

            // Thực hiện xóa breed
            $breed->delete();

            // Nếu thành công, quay lại trang danh sách với thông báo thành công
            return redirect()->route('breeds.index')->with('success', 'BreedModel deleted successfully.');

        } catch (\Exception $e) {
            // Nếu có lỗi, quay lại trang danh sách với thông báo lỗi
            return redirect()->route('breeds.index')->with('error', 'Error occurred while deleting breed: ' . $e->getMessage());
        }
    }
}
