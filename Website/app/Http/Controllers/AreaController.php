<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $areas = DB::table('areas')->get(); // Thực hiện truy vấn để lấy dữ liệu
        // Truyền dữ liệu vào view
        return view('area/listarea', ['areas' => $areas]);
    }

    public function addArea(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('areas')->insert([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('listarea')->with('success', 'Area added successfully!');
    }

    public function delArea($id)
    {
        DB::table('areas')->where('id', $id)->delete();
        return redirect()->route('listarea')->with('success', 'Area deleted successfully!');
    }
    public function udpArea(Request $request, $area_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DB::table('areas')->where('id', $area_id)->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'updated_at' => now(),
        ]);

        return redirect()->route('listarea')->with('success', 'Area updated successfully!');
    }

}
