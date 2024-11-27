<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;

class DeviceController extends Controller
{
    //
    function getView()
    {
        $devices = DB::table('devices')->get();
        return view('device/dashboard',['devices' => $devices]);
    }


    function detailDevice($id){
        $detailDevice = Device::where('device_id', $id)->first();

        if (!$detailDevice) {
            abort(404, 'Device not found'); // Xử lý nếu không tìm thấy thiết bị
        }

        // dd($detailDevice);
        return view('device/show', ['detailDevice' => $detailDevice]);
    }
}
