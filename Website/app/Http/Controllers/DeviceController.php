<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Device;


class DeviceController extends Controller
{
    // Hiển thị danh sách thiết bị
    public function index()
    {
        // Lấy farm_id từ seccion
        $farm_id = Auth::user()->farm_id;

        // Lấy danh sách thiết bị với farm id qua table device_types lấy type_device_name
        $devices = Device::where('farm_id', $farm_id)
            ->join('type_devices', 'farm_devices.type_device_id', '=', 'type_devices.type_device_id')
            ->select('farm_devices.*', 'type_devices.type_device_name')
            ->get();

//        dd($devices);

        $type_devices = DB::table('type_devices')->get();

        return view('devices.index', ['devices' => $devices, 'type_devices' => $type_devices]);
    }

    public function show($id)
    {
        // Lấy chi tiết thiết bị với $id
        $device = Device::find($id)
            ->join('type_devices', 'farm_devices.type_device_id', '=', 'type_devices.type_device_id')
            ->select('farm_devices.*', 'type_devices.type_device_name')
            ->first();
        return view('devices.show', ['device' => $device]);
    }

    // Thêm thiết bị
    public function add(Request $request){

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

        return redirect()->route('devices.index')->with('success', 'Device added successfully.');
        } catch (\Exception $e) {
            // LogModel the error for debugging
            Log::error('Error inserting breed: ' . $e->getMessage());

            return redirect()->route('devices.index')->with('error', 'Failed to add device. Please try again.');
        }
    }

    // Xóa thiết bị
    public function del($id)
    {
        $device = DB::table('farm_devices')->where('device_id', $id)->first();

        if ($device) {
            DB::table('farm_devices')->where('device_id', $id)->delete();
            return redirect()->route('devices.index')->with('success', 'Device deleted successfully.');
        }

        return redirect()->route('devices.index')->with('error', 'Device not found.');
    }

    // Cập nhật thiết bị
    public function udp(Request $request, $device_id)
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

            return redirect()->route('devices.index')->with('success', 'Device updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('devices.index')->with('error', 'Failed to update device. Please try again.');
        }
    }
}
