<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\BarnModel;
use App\Models\ZoneModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BarnController extends Controller
{

    public function index()
    {
        $barns = BarnModel::all(); // Lấy danh sách chuồng
        $zones = ZoneModel::all(); // Lấy danh sách khu vực (zones)
        $areas = AreaModel::all(); // Lấy danh sách khu vực (areas)

        return view('barns.index', compact('barns', 'zones', 'areas'));
    }

    // Show details of a specific barn
    public function show($id)
    {
        $barn = DB::table('farm_barns')->where('barn_id', $id)->first(); // Get barn by ID
        if (!$barn) {
            return redirect()->route('barn.list')->with('error', 'BarnModel not found.');
        }
        return view('barns.show', ['barn' => $barn]); // Show details view
    }

    public function getView()
    {

        $farm_id = Session::get('user_farm_id');

        // Lấy zones thuộc farm_id
        $zones = DB::table('zones')->where('farm_id', $farm_id)->get();

        $areas = AreaModel::all()->where('farm_id', $farm_id);

        $barns = DB::table('farm_barns')
            ->join('farm_areas', 'farm_barns.area_id', '=', 'farm_areas.area_id')
            ->join('zones', 'farm_areas.zone_id', '=', 'zones.zone_id')
            ->join('farms', 'zones.farm_id', '=', 'farms.farm_id')
            ->where('farms.farm_id', $farm_id) // Chỉ định rõ bảng chứa farm_id
            ->select('farm_barns.*') // Chọn các cột cần thiết
            ->get();

        return view('barns.index', ['barns' => $barns, 'zones' => $zones, 'areas' => $areas]); // Pass the zones to the view
    }

      // Thêm mới một barn
      public function add(Request $request)
      {
//          dd($request->all());

          $validated = $request->validate([
              'area_id' => 'required|integer', // Đảm bảo trường 'area_id' được cung cấp
              'barn_name' => 'required|string|max:255', // Đảm bảo trường 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không buộc
          ]);

          $farm_id = Session::get('user_farm_id');

//          DB::table('barns')->insert([
//              'barn_name' => $validated['barn_name'],
//              'description' => $validated['description'],
//              'farm_id' =>  $farm_id, // Cung cấp giá trị cho 'farm_id'
//          ]);

          BarnModel::create([
            'area_id' => $validated['area_id'],
            'barn_name' => $validated['barn_name'],
            'description' => $validated['description'],
            'farm_id' =>  $farm_id, // Cung cấp giá trị cho 'farm_id'
          ]);

          return redirect()->route('barns.index')->with('success', 'BarnModel added successfully!');
    }


      // Xóa một barn
      public function delBarn($barn_id)
      {
          DB::table('farm_barns')->where('barn_id', $barn_id)->delete(); // Xóa bản ghi theo 'barn_id'
          return redirect()->route('barns.index')->with('success', 'BarnModel deleted successfully!');
      }

      // Cập nhật một barn
      public function udpBarn(Request $request, $barn_id)
      {
          $validated = $request->validate([
              'barn_name' => 'required|string|max:255', // Đảm bảo 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không bắt buộc
          ]);

          DB::table('farm_barns')->where('barn_id', $barn_id)->update([
              'barn_name' => $validated['barn_name'],
              'description' => $validated['description'],
          ]);

          return redirect()->route('barns.index')->with('success', 'BarnModel updated successfully!');
      }


}

