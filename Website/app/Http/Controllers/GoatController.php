<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoatController extends Controller
{
    public function show($id)
    {
        $goat = Goat::findOrFail($id);
        return view('goats.show', compact('goat'));
    }
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $listgoats = DB::table('goats')->get(); // Thực hiện truy vấn để lấy dữ liệu
        
        // Truyền dữ liệu vào view
        return view('goats.listgoat', ['listgoats' => $listgoats]);
    }


    public function addGoat(Request $request)
    {
        // Debugging: Check all request data
        // dd($request->all()); // This will show all request data and stop the script
        $goat_id = $request->input('goat_id');
        $goat_name = $request->input('goat_name');
        $location = $request->input('goat_age');
        $owner_id = $request->input('origin');

        // Insert to database
        DB::table('goats')->insert([
            'goat_id' => $goat_id,
            'goat_name' => $goat_name,
            'goat_age' => $goat_age,
            'origin' => $origin
        ]);

        $farms = DB::table('goats')->get();
        return view('goat/listgoat',['goats' => $goats]);
    }

}
