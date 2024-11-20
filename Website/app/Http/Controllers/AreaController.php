<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function getView()
    {
        // Lấy danh sách từ bảng 'goats'
        $farms = DB::table('areas')->get(); // Thực hiện truy vấn để lấy dữ liệu
        // Truyền dữ liệu vào view
        return view('area/listarea', ['areas' => $areas]);
    }
}
