<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Device;

class DeviceController extends Controller
{
    // Hiển thị danh sách thiết bị
    public function getView()
    {
        $devices = DB::table('devices')
            ->join('farms', 'devices.farm_id', '=', 'farms.farm_id')
            ->join('device_types', 'devices.type_device_id', '=', 'device_types.id')
            ->select('devices.*', 'farms.farm_name', 'device_types.type_name')
            ->get();

        return view('device.list', ['devices' => $devices]);
    }

    // Thêm thiết bị
    public function addDevice(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'device_name' => 'required|string|max:255',
            'type_device_id' => 'required|integer|exists:device_types,id',
            'farm_id' => 'required|integer|exists:farms,farm_id',
        ]);

        try {
            // Tạo thiết bị mới
            DB::table('devices')->insert([
                'device_name' => $request->input('device_name'),
                'type_device_id' => $request->input('type_device_id'),
                'farm_id' => $request->input('farm_id'),
                'status' => 'Active',
            ]);

            return redirect()->route('devices.list')->with('success', 'Device added successfully.');
        } catch (\Exception $e) {
            return redirect()->route('devices.list')->with('error', 'Failed to add device. Please try again.');
        }
    }

    // Xóa thiết bị
    public function delDevice($device_id)
    {
        $device = DB::table('devices')->where('device_id', $device_id)->first();

        if ($device) {
            DB::table('devices')->where('device_id', $device_id)->delete();
            return redirect()->route('devices.list')->with('success', 'Device deleted successfully.');
        }

        return redirect()->route('devices.list')->with('error', 'Device not found.');
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
            DB::table('devices')->where('device_id', $device_id)->update([
                'device_name' => $request->input('device_name'),
                'type_device_id' => $request->input('type_device_id'),
            ]);

            return redirect()->route('devices.list')->with('success', 'Device updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('devices.list')->with('error', 'Failed to update device. Please try again.');
        }
    }
}
