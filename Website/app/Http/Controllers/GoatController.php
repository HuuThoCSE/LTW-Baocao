<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoatController extends Controller
{
    public function show($id)
    {
        $goat = DB::table('goats')->where('goat_id', $id)->first();
    
        if (!$goat) {
            abort(404);
        }
        
        return view('goats.show', compact('goat'));
    }
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $listgoats = DB::table('goats')->get(); // Thực hiện truy vấn để lấy dữ liệu
        
        // Truyền dữ liệu vào view
        return view('goats.listgoat', ['listgoats' => $listgoats]);
    }
}
