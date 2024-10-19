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
}
