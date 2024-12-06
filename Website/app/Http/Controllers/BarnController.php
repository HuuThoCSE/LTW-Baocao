<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BarnController extends Controller
{

    public function index()
    {
        $barns = Barn::all(); // Lấy danh sách chuồng
        $zones = Zone::all(); // Lấy danh sách khu vực (zones)

        return view('barns.index', compact('barns', 'zones'));
    }

    // Show details of a specific barn
    public function show($id)
    {
        $barn = DB::table('barns')->where('barn_id', $id)->first(); // Get barn by ID
        if (!$barn) {
            return redirect()->route('listbarn')->with('error', 'Barn not found.');
        }
        return view('barn/show', ['barn' => $barn]); // Show details view
    }

    public function getView()
    {

        $farm_id = Session::get('user_farm_id');

        // Lấy zones thuộc farm_id
        $zones = DB::table('zones')->where('farm_id', $farm_id)->get();

        $barns = DB::table('barns')
            ->join('areas', 'barns.area_id', '=', 'areas.area_id')
            ->join('zones', 'areas.zone_id', '=', 'zones.zone_id')
            ->join('farms', 'zones.farm_id', '=', 'farms.farm_id')
            ->where('farms.farm_id', $farm_id) // Chỉ định rõ bảng chứa farm_id
            ->select('barns.*') // Chọn các cột cần thiết
            ->get();

        return view('barn/listbarn', ['barns' => $barns, 'zones' => $zones]); // Pass the zones to the view
    }

      // Thêm mới một barn
      public function addBarn(Request $request)
      {
          $validated = $request->validate([
              'barn_name' => 'required|string|max:255', // Đảm bảo trường 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không bắt buộc
          ]);

          $farm_id = Session::get('user_farm_id');

          DB::table('barns')->insert([
              'barn_name' => $validated['barn_name'],
              'description' => $validated['description'],
              'farm_id' => $validated['farm_id'], // Cung cấp giá trị cho 'farm_id'
          ]);

          return redirect()->route('listbarn.dashboard')->with('success', 'Barn added successfully!');
    }



      // Xóa một barn
      public function delBarn($barn_id)
      {
          DB::table('barns')->where('barn_id', $barn_id)->delete(); // Xóa bản ghi theo 'barn_id'
          return redirect()->route('listbarn.dashboard')->with('success', 'Barn deleted successfully!');
      }

      // Cập nhật một barn
      public function udpBarn(Request $request, $barn_id)
      {
          $validated = $request->validate([
              'barn_name' => 'required|string|max:255', // Đảm bảo 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không bắt buộc
          ]);

          DB::table('barns')->where('barn_id', $barn_id)->update([
              'barn_name' => $validated['barn_name'],
              'description' => $validated['description'],
          ]);

          return redirect()->route('listbarn.dashboard')->with('success', 'Barn updated successfully!');
      }


}

