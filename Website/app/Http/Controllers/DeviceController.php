<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Device;


class DeviceController extends Controller
{
    // Hiển thị danh sách thiết bị
    public function getView()
    {
        // Lấy farm_id từ seccion
        $farm_id = Session::get('user_farm_id');

        // Lấy danh sách thiết bị với farm id qua table device_types lấy type_device_name
        $devices = Device::where('farm_id', $farm_id)
            ->join('type_devices', 'farm_devices.type_device_id', '=', 'type_devices.type_device_id')
            ->select('farm_devices.*', 'type_devices.type_device_name')
            ->get();

//        dd($devices);

        $type_devices = DB::table('type_devices')->get();

        return view('device.index', ['devices' => $devices, 'type_devices' => $type_devices]);
    }

    public function show($id)
    {
        // Lấy chi tiết thiết bị với $id
        $device = Device::find($id)
            ->join('type_devices', 'farm_devices.type_device_id', '=', 'type_devices.type_device_id')
            ->select('farm_devices.*', 'type_devices.type_device_name')
            ->first();
        return view('device.show', ['device' => $device]);
    }

    // Thêm thiết bị
    public function addDevice(Request $request){

//        dd($request->all());

        // Validate dữ liệu
        $request->validate([
            'device_name' => 'required|string|max:255',
            'type_device_id' => 'required|integer|exists:type_devices,type_device_id',
        ]);

        $farm_id = Session::get('user_farm_id');

        try {
            // Tạo thiết bị mới
            DB::table('farm_devices')->insert([
                'device_name' => $request->input('device_name'),
                'type_device_id' => $request->input('type_device_id'),
                'farm_id' => $farm_id,
                'status' => 'Active',
        ]);
        return redirect()->route('device.list')->with('success', 'Device added successfully.');
        } catch (\Exception $e) {
            // LogModel the error for debugging
            Log::error('Error inserting breed: ' . $e->getMessage());

            return redirect()->route('device.list')->with('error', 'Failed to add device. Please try again.');
        }
    }

    // Xóa thiết bị
    public function delDevice($id)
    {
        $device = DB::table('farm_devices')->where('device_id', $id)->first();

        if ($device) {
            DB::table('farm_devices')->where('device_id', $id)->delete();
            return redirect()->route('device.list')->with('success', 'Device deleted successfully.');
        }

        return redirect()->route('device.list')->with('error', 'Device not found.');
    }

    // Cập nhật thiết bị
    public function udpDevice(Request $request, $device_id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'device_name' => 'required|string|max:255',
            'type_device_id' => 'required|integer|exists:device_types,id',
        ]);

        try {
            // Cập nhật thiết bị
            DB::table('farm_devices')->where('device_id', $device_id)->update([
                'device_name' => $request->input('device_name'),
                'type_device_id' => $request->input('type_device_id'),
            ]);

            return redirect()->route('device.list')->with('success', 'Device updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('device.list')->with('error', 'Failed to update device. Please try again.');
        }
    }
}
