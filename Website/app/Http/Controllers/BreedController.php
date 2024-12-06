<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Breed;

class BreedController extends Controller
{
    public function getView()
    {
        // if(empty(Session::get('user_farm_id'))){
        //     return redirect()->route('login');
        // }

        $breeds = DB::table('breeds')->get();
        return view('breed.breed-list', ['breeds' => $breeds]);
    }

    public function add(Request $request)
    {
        // Get the farm_id from session
        $farm_id = Session::get('user_farm_id');

        // dd($request);

        // Validate input
        $request->validate([
            'breed_name_eng' => 'required|string|max:255',
            'breed_name_vie' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',  // Optional field
        ]);


        try {
            // Insert the new breed into the database
            DB::table('breeds')->insert([
                'breed_name_eng' => $request->breed_name_eng,  // Input from form
                'breed_name_vie' => $request->breed_name_vie,  // Input from form
                'description' => $request->description,        // Input from form
                'farm_id' => $farm_id,                         // Farm ID from session
            ]);

            // Return success message and redirect
            return redirect()->route('breed.list')->with('success', 'Breed added successfully');
        } catch (\Exception $e) {
            // LogModel the error for debugging
            \Log::error('Error inserting breed: ' . $e->getMessage());

            // Return error message and redirect
            return redirect()->route('breed.list')->with('error', 'Failed to add breed. Please try again.');
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
        $breed = Breed::find($id);

        // Kiểm tra xem giống có tồn tại hay không
        if (!$breed) {
            return redirect()->route('breed.list')->with('error', 'Breed not found.');
        }

        // Cập nhật thông tin giống
        $breed->breed_name_eng = $request->breed_name_eng;
        $breed->breed_name_vie = $request->breed_name_vie;
        $breed->description = $request->description;

        // Lưu thay đổi vào cơ sở dữ liệu
        $breed->save();

        // Quay lại với thông báo thành công
        return redirect()->route('breed.list')->with('success', 'Breed updated successfully.');
    }

    // Delete a breed
    public function del($id)
    {
        try {
            // Tìm breed theo ID
            $breed = Breed::find($id);

            // Kiểm tra nếu không tìm thấy breed
            if (!$breed) {
                return redirect()->back()->with('error', 'Breed not found.');
            }

            // Thực hiện xóa breed
            $breed->delete();

            // Nếu thành công, quay lại trang danh sách với thông báo thành công
            return redirect()->route('breed.list')->with('success', 'Breed deleted successfully.');

        } catch (\Exception $e) {
            // Nếu có lỗi, quay lại trang danh sách với thông báo lỗi
            return redirect()->route('breed.list')->with('error', 'Error occurred while deleting breed: ' . $e->getMessage());
        }
    }
}
