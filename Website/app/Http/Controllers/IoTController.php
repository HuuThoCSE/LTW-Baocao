<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IoTController extends Controller
{
    public function index()
    {
        return view('iot.index');
    }

    public function control(Request $request)
    {
        // Xử lý điều khiển thiết bị IoT
        return response()->json([
            'success' => true,
            'message' => 'Đã gửi lệnh điều khiển'
        ]);
    }
}
