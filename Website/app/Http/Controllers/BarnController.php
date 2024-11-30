<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $barns = DB::table('barns')->get(); // Get zones from the database
        return view('barn/listbarn', ['barns' => $barns]); // Pass the zones to the view
    }
    
      // Thêm mới một barn
      public function addBarn(Request $request)
      {
          $validated = $request->validate([
       
              'barn_name' => 'required|string|max:255', // Đảm bảo trường 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không bắt buộc
              'farm_id' => 'required|integer', // Kiểm tra 'farm_id' là số nguyên
          ]);
  
          DB::table('barns')->insert([
              'barn_name' => $validated['barn_name'],
              'description' => $validated['description'],
              'farm_id' => $validated['farm_id'], // Cung cấp giá trị cho 'farm_id'
          ]);
  
          return redirect()->route('listbarn')->with('success', 'Barn added successfully!');
     
    }
    

  
      // Xóa một barn
      public function delBarn($id)
      {
          DB::table('barns')->where('barn_id', $id)->delete(); // Xóa bản ghi theo 'barn_id'
          return redirect()->route('listbarn')->with('success', 'Barn deleted successfully!');
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
  
          return redirect()->route('listbarn')->with('success', 'Barn updated successfully!');
      }

      
}

