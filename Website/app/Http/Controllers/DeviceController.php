<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    //
    function getView()
    {
        $devices = DB::table('devices')->get();
        return view('device/dashboard',['devices' => $devices]);
    }
}
