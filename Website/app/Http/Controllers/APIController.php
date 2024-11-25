<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class APIController extends Controller
{
    public function addHumidity(Request $request)
    {
        $sensor_id = $request->input('sensor_id');
        $sensor_type = $request->input('sensor_type');
        $value = $request->input('value');

        try {
            SensorData::create([
                'sensor_id' => $sensor_id,
                'sensor_type' => $sensor_type,
                'value' => $value
            ]);
            return 'Data added successfully';
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}