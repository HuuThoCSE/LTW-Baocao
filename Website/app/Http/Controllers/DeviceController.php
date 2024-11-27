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

    function addDevice(Request $request){
        $device_name = $request->input('device_name');
        $device_type = $request->input('device_type');
        $farm_id = Session::get('farm_id');


        // Tạo thiết bị
        $device = Device::create([
            'device_name' => $device_name,
            'farm_id' => $farm_id,
            'type_device_id' => 1,
            'status' => 'Active',
        ]);

        // Kiểm tra xem thiết bị đã được thêm chưa
        if ($device) {
            return response()->json([
                'message' => 'Thêm thiết bị thành công!',
                'device' => $device,
            ]);
        } else {
            return response()->json([
                'message' => 'Thêm thiết bị thất bại.',
            ], 500);
        }
        }
}
