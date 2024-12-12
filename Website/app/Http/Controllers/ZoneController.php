<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZoneController extends Controller
{
    public function getView()
    {
        $zones = DB::table('zones')->get(); // Get zones from the database
        return view('zones.index', ['zones' => $zones]); // Pass the zones to the view
    }

    // Add a new zone
    public function addZone(Request $request)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255', // Ensure correct field name for 'zone_name'
            'description' => 'nullable|string',
            'farm_id' => 'required|integer', // Thêm kiểm tra cho 'farm_id'

        ]);

        DB::table('zones')->insert([
            'zone_name' => $validated['zone_name'],
            'description' => $validated['description'],
            'farm_id' => $validated['farm_id'], // Cung cấp giá trị cho 'farm_id'

        ]);

        return redirect()->route('listzone.dashboard')->with('success', 'Zone added successfully!');
    }

    // Delete a zone
    public function delZone($zone_id)
    {
        DB::table('zones')->where('zone_id', $zone_id)->delete(); // Ensure using correct 'zone_id'
        return redirect()->route('listzone.dashboard')->with('success', 'Zone deleted successfully!');
    }

    // Update an existing zone
    public function udpZone(Request $request, $zone_id)
    {
        $validated = $request->validate([
            'zone_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('zones')->where('zone_id', $zone_id)->update([ // Update by 'zone_id'
            'zone_name' => $validated['zone_name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('listzone.dashboard')->with('success', 'Zone updated successfully!');
    }

    public function getAreaByZone(Request $request)
    {
        // Lấy zone_id từ request
        $zone_id = $request->input('zone_id');

        // Truy vấn để lấy area tương ứng
        $area = DB::table('zones')
            ->join('areas', 'zones.area_id', '=', 'areas.area_id')
            ->where('zones.zone_id', $zone_id)
            ->select('areas.area_id', 'areas.area_name') // Chỉ lấy thông tin cần thiết
            ->first();

        // Trả về JSON để AJAX xử lý
        return response()->json($area);
    }
}
