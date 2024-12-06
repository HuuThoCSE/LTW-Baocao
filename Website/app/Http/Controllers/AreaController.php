<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AreaController extends Controller
{
    public function getView()
    {
        // // Lấy danh sách từ bảng 'goats'
        // $areas = DB::table('areas')->get(); // Thực hiện truy vấn để lấy dữ liệu
        // // Truyền dữ liệu vào view
        // return view('area/listarea', ['areas' => $areas]);

        $farm_id = Session::get('user_farm_id');

        // Lấy zones thuộc farm_id
        $zones = DB::table('zones')->where('farm_id', $farm_id)->get();

        $areas = DB::table('farm_areas')
   
            ->join('zones', 'farm_areas.zone_id', '=', 'zones.zone_id')
            ->join('farms', 'zones.farm_id', '=', 'farms.farm_id')
            ->where('farms.farm_id', $farm_id) // Chỉ định rõ bảng chứa farm_id
            ->select('farm_areas.*') // Chọn các cột cần thiết
            ->get(); 
        
        return view('area/listarea', ['farm_areas' => $areas, 'zones' => $zones]); // Pass the zones to the view
    }

    public function addArea(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'zone_id' => 'required|exists:zones,zone_id',  // Đảm bảo zone_id hợp lệ
        ]);

        DB::table('areas')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'zone_id' => $validated['zone_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('listarea.dashboard')->with('success', 'AreaModel added successfully!');
    }

    public function delArea($area_id)
    {
        DB::table('areas')->where('area_id', $area_id)->delete();
        return redirect()->route('listarea.dashboard')->with('success', 'AreaModel deleted successfully!');
    }
    public function udpArea(Request $request, $area_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('areas')->where('area_id', $area_id)->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'updated_at' => now(),
        ]);

        return redirect()->route('listarea.dashboard')->with('success', 'AreaModel updated successfully!');
    }
    public function getAreasByZone(Request $request)
    {
        // Lấy zone_id từ request
        $zoneId = $request->zone_id;

        // Kiểm tra nếu zone_id có giá trị
        if ($zoneId) {
            $areas = Area::where('zone_id', $zoneId)->get(); // Lấy các area dựa trên zone_id

            // Trả về dữ liệu dưới dạng JSON
            return response()->json($areas);
        }

        // Nếu không có zone_id, trả về mảng rỗng
        return response()->json([]);
    }



}
