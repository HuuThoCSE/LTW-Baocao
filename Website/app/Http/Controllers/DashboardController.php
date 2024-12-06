<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoatModel; // Model đại diện cho bảng goat
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function getView()
    {
        return view('dashboard');
    }

    public function getGoatData()
    {
        $data = GoatModel::select('farm_id', DB::raw('COUNT(goat_id) as quantity'))
        ->groupBy('farm_id')
        ->with('farm') // Kèm thông tin chuồng
        ->get();

    return response()->json($data);
    }




}
