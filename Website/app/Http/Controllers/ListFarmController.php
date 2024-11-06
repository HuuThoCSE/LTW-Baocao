<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //Kiểm tra lỗi khi ô bị bỏ trống
        $request->validate([
            'farm_name' => 'required|string|max:255', // Farm name is required, must be a string, and max 255 characters
            'location' => 'required|string', // Location is required and must be a string
            'owner_id' => 'required|integer', // Owner ID is required and must be an integer
        ]);
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script
        $farm_id = $request->input('farm_id');
        $farm_name = $request->input('farm_name');
        $location = $request->input('location');
        $owner_id = $request->input('owner_id');

        // Insert to database
        DB::table('farms')->insert([ 
            'farm_name' => $farm_name,
            'location' => $location,
            'owner_id' => $owner_id
        ]);

        // $farms = DB::table('farms')->get();
        // return view('farm/dashboard',['farms' => $farms]);
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
