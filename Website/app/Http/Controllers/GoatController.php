<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Farm;
use Illuminate\Support\Facades\Session;


class GoatController extends Controller
{
    public function getView()
    {

        // Lấy danh sách từ bảng 'goats'
        // $goats = DB::table('goats')->get(); // Thực hiện truy vấn để lấy dữ liệu

        $breeds = DB::table('farm_breeds')->get(); // Lấy danh sách các giống dê

        $goats = DB::table('goats')
            ->join('farms', 'goats.farm_id', '=', 'farms.farm_id')
            ->join('farm_breeds', 'goats.breed_id', '=', 'farm_breeds.breed_id')
            ->select('goats.*', 'farms.farm_name', 'farm_breeds.breed_name_vie')
            ->get();

        // Truyền dữ liệu vào view
        return view('goats.dashboard', ['goats' => $goats, 'breeds' => $breeds]);
    }

    public function addGoat(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'goat_name' => 'required|string|max:255', // Goat name is required and should be a string
            'goat_age' => 'required|integer', // Goat age is required and should be an integer
            'origin' => 'required|string', // Origin is required and should be a string
            'farm_id' => 'required|integer|exists:farms,farm_id',  // Farm ID is required, should be an integer, and must exist in the 'farms' table
            'breed_id' => 'required|integer|exists:farm_breeds,breed_id', // Breed ID is required, should be an integer, and must exist in the 'breeds' table
        ]);


        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script

        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $farm_id = $request->input('farm_id');
        $breed_id = $request->input('breed_id');

        $farm_id = Session::get('farm_id');
        // Insert to database



        try {
            // Insert the new goat into the database
            DB::table('goats')->insert([
                'goat_name' => $goat_name,
                'goat_age' => $goat_age,
                'origin' => $origin,
                'farm_id' => $farm_id,
                'breed_id' => $breed_id,
                'type_device_id' => 1,
                'status' => 'Active',
            ]);

            // Thêm thông báo thành công
            return redirect()->route('goats.list')->with('success', 'Goat added successfully');
        } catch (\Exception $e) {
            // Thêm thông báo lỗi
            return redirect()->route('goats.list')->with('error', 'Failed to add goat. Please try again.');
        }


    }


    public function delGoat($goat_id)
    {

    // Find the goat by its ID
    $goat = DB::table('goats')->where('goat_id', $goat_id)->first();

    if ($goat) {
        // Delete the goat if found
        DB::table('goats')->where('goat_id', $goat_id)->delete();
        return redirect()->back()->with('success', 'Goat deleted successfully.');
    } else {
        // If the goat doesn't exist, return an error
        return redirect()->back()->with('error', 'Goat not found.');
    }


    }
    public function udpGoat(Request $request, $goat_id)
    {
        // Lấy dữ liệu từ request
        $goat_name = $request->input('goat_name');
        $goat_age = $request->input('goat_age');
        $origin = $request->input('origin');
        $farm_id = $request->input('farm_id'); // Lấy farm_id từ form
        $breed_id = $request->input('breed_id');

        // Kiểm tra farm_id có tồn tại không
        if (!$farm_id) {
            return redirect()->back()->with('error', 'Farm ID is missing.');
        }

        // Cập nhật bảng farms
         // Cập nhật thông tin cho con dê
        $updated = DB::table('goats')->where('goat_id', $goat_id)->update([
            'goat_name' => $goat_name,
            'goat_age' => $goat_age,
            'origin' => $origin,
            'farm_id' => $farm_id, // Cập nhật farm_id cho con dê
            'breed_id' => $breed_id, // Cập nhật breed_id nếu cần
        ]);

        // Truy xuất lại danh sách
        $farms = DB::table('goats')->get();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('goats.list')->with('success', 'Farm updated successfully.');
    }



}
