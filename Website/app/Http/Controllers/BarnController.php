<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaModel;
use App\Models\BarnModel;
use App\Models\ZoneModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class BarnController extends Controller
{

    public function index()
    {
        $barns = BarnModel::all(); // Lấy danh sách chuồng
        $zones = ZoneModel::all(); // Lấy danh sách khu vực (zones)
        $areas = AreaModel::all(); // Lấy danh sách khu vực (areas)

        return view('barns.index', compact('barns', 'zones', 'areas'));
    }

    // Show details of a specific barn
    public function show($id)
    {
        $barn = BarnModel::findOrFail($id);
        // Debug để xem thông tin của $barn
        \Log::info('Barn information:', ['barn' => $barn->toArray()]);

        // Format barn_id cho đúng định dạng BARN-001
        $deviceId = sprintf("BARN-%03d", $barn->barn_id);
        \Log::info('Formatted device ID:', ['device_id' => $deviceId]);

        $temperatureData = [
            'timestamps' => [],
            'values' => []
        ];
        
        $humidityData = [
            'timestamps' => [],
            'values' => []
        ];

        // Lấy thời gian bắt đầu (00:00) và kết thúc (23:59:59) của ngày hiện tại
        $startTime = Carbon::now()->startOfDay();
        $endTime = Carbon::now()->endOfDay();

        // Khởi tạo InfluxDB client
        $client = new \InfluxDB2\Client([
            "url" => env('INFLUXDB_URL'),
            "token" => env('INFLUXDB_TOKEN'),
            "org" => env('INFLUXDB_ORG'),
            "bucket" => env('INFLUXDB_BUCKET'),
        ]);

        $queryApi = $client->createQueryApi();

        \Log::info('Query parameters:', [
            'device_id' => $deviceId,
            'start_time' => $startTime->format('Y-m-d\TH:i:s\Z'),
            'end_time' => $endTime->format('Y-m-d\TH:i:s\Z')
        ]);

        $query = 'from(bucket:"' . env('INFLUXDB_BUCKET') . '")
            |> range(start: ' . $startTime->format('Y-m-d\TH:i:s\Z') . ', stop: ' . $endTime->format('Y-m-d\TH:i:s\Z') . ')
            |> filter(fn: (r) => r["_measurement"] == "barn_environment")
            |> filter(fn: (r) => r["barn_id"] == "' . $deviceId . '")
            |> filter(fn: (r) => r["_field"] == "temperature" or r["_field"] == "humidity")
            |> keep(columns: ["_time", "_value", "_field"])
            |> group(columns: ["_field"])
            |> distinct(column: "_value")
            |> sort(columns: ["_time"])';

        \Log::info('InfluxDB Query:', ['query' => $query]);

        try {
            $result = $queryApi->query($query);
            \Log::info('Query result:', ['result' => $result]);

            $processedTemp = [];
            $processedHum = [];
            
            foreach ($result as $table) {
                foreach ($table->records as $record) {
                    $field = $record->values['_field'];
                    $value = floatval($record->values['_value']);
                    $timestamp = Carbon::parse($record->values['_start'])->format('H:i');
                    
                    $dataPoint = $timestamp . '_' . $value;
                    
                    if ($field === 'temperature' && !isset($processedTemp[$dataPoint])) {
                        $temperatureData['timestamps'][] = $timestamp;
                        $temperatureData['values'][] = round($value, 2);
                        $processedTemp[$dataPoint] = true;
                    } elseif ($field === 'humidity' && !isset($processedHum[$dataPoint])) {
                        $humidityData['timestamps'][] = $timestamp;
                        $humidityData['values'][] = round($value, 2);
                        $processedHum[$dataPoint] = true;
                    }
                }
            }

            array_multisort($temperatureData['timestamps'], SORT_ASC, $temperatureData['values']);
            array_multisort($humidityData['timestamps'], SORT_ASC, $humidityData['values']);

            \Log::info('Processed Temperature Data:', $temperatureData);
            \Log::info('Processed Humidity Data:', $humidityData);

        } catch (\Exception $e) {
            \Log::error('InfluxDB Query Error:', ['error' => $e->getMessage()]);
        }

        return view('barns.show', compact('barn', 'temperatureData', 'humidityData'));
    }

    public function getView()
    {

        $farm_id = Session::get('user_farm_id');

        // Lấy zones thuộc farm_id
        $zones = DB::table('zones')->where('farm_id', $farm_id)->get();

        $areas = AreaModel::all()->where('farm_id', $farm_id);

        $barns = DB::table('farm_barns')
            ->join('farm_areas', 'farm_barns.area_id', '=', 'farm_areas.area_id')
            ->join('zones', 'farm_areas.zone_id', '=', 'zones.zone_id')
            ->join('farms', 'zones.farm_id', '=', 'farms.farm_id')
            ->where('farms.farm_id', $farm_id) // Chỉ định rõ bảng chứa farm_id
            ->select('farm_barns.*') // Chọn các cột cần thiết
            ->get();

        return view('barns.index', ['barns' => $barns, 'zones' => $zones, 'areas' => $areas]); // Pass the zones to the view
    }

      // Thêm mới một barn
      public function add(Request $request)
      {
//          dd($request->all());

          $validated = $request->validate([
              'area_id' => 'required|integer', // Đảm bảo trường 'area_id' được cung cấp
              'barn_name' => 'required|string|max:255', // Đảm bảo trường 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không buộc
          ]);

          $farm_id = Session::get('user_farm_id');

//          DB::table('barns')->insert([
//              'barn_name' => $validated['barn_name'],
//              'description' => $validated['description'],
//              'farm_id' =>  $farm_id, // Cung cấp giá trị cho 'farm_id'
//          ]);

          BarnModel::create([
            'area_id' => $validated['area_id'],
            'barn_name' => $validated['barn_name'],
            'description' => $validated['description'],
            'farm_id' =>  $farm_id, // Cung cấp giá trị cho 'farm_id'
          ]);

          return redirect()->route('barns.index')->with('success', 'BarnModel added successfully!');
    }


      // Xóa một barn
      public function delBarn($barn_id)
      {
          DB::table('farm_barns')->where('barn_id', $barn_id)->delete(); // Xóa bản ghi theo 'barn_id'
          return redirect()->route('barns.index')->with('success', 'BarnModel deleted successfully!');
      }

      // Cập nhật một barn
      public function udpBarn(Request $request, $barn_id)
      {
          $validated = $request->validate([
              'barn_name' => 'required|string|max:255', // Đảm bảo 'barn_name' được cung cấp
              'description' => 'nullable|string', // 'description' không bắt buộc
          ]);

          DB::table('farm_barns')->where('barn_id', $barn_id)->update([
              'barn_name' => $validated['barn_name'],
              'description' => $validated['description'],
          ]);

          return redirect()->route('barns.index')->with('success', 'BarnModel updated successfully!');
      }

      public function getHumidityData($deviceId)
      {
          try {
              // Log input parameter
              \Log::info('Getting humidity data for device:', ['deviceId' => $deviceId]);

              $client = new \InfluxDB2\Client([
                  "url" => env('INFLUXDB_URL'),
                  "token" => env('INFLUXDB_TOKEN'),
                  "org" => env('INFLUXDB_ORG'),
                  "bucket" => env('INFLUXDB_BUCKET'),
              ]);

              // Log configuration
              \Log::info('InfluxDB Configuration:', [
                  'url' => env('INFLUXDB_URL'),
                  'org' => env('INFLUXDB_ORG'),
                  'bucket' => env('INFLUXDB_BUCKET')
              ]);

              $queryApi = $client->createQueryApi();
              
              $query = 'from(bucket:"' . env('INFLUXDB_BUCKET') . '")
                  |> range(start: -1h)
                  |> filter(fn: (r) => r["_measurement"] == "barn_environment")
                  |> filter(fn: (r) => r["_field"] == "humidity")
                  |> filter(fn: (r) => r["barn_id"] == "BARN-00' . $deviceId . '")
                  |> aggregateWindow(every: 5m, fn: mean, createEmpty: false)
                  |> yield(name: "mean")';

              // Log the query
              \Log::info('InfluxDB Query:', ['query' => $query]);

              $result = $queryApi->query($query);

              // Log raw result
              \Log::info('Raw Query Result:', ['result' => json_encode($result)]);

              $timestamps = [];
              $values = [];

              foreach ($result as $table) {
                  // Log table information
                  \Log::info('Processing table:', ['table' => json_encode($table)]);
                  
                  foreach ($table->records as $record) {
                      // Log each record
                      \Log::info('Processing record:', [
                          'time' => $record->getTime(),
                          'value' => $record->getValue()
                      ]);
                      
                      $timestamp = new \DateTime($record->getTime());
                      $timestamps[] = $timestamp->format('H:i');
                      $values[] = round($record->getValue(), 2);
                  }
              }

              // Log final processed data
              \Log::info('Processed Data:', [
                  'timestamps' => $timestamps,
                  'values' => $values
              ]);

              return response()->json([
                  'timestamps' => $timestamps,
                  'values' => $values
              ]);

          } catch (\Exception $e) {
              \Log::error('InfluxDB Error:', [
                  'message' => $e->getMessage(),
                  'trace' => $e->getTraceAsString()
              ]);
              
              return response()->json([
                  'error' => 'Failed to fetch data from InfluxDB',
                  'message' => $e->getMessage()
              ], 500);
          }
      }

      public function getData(BarnModel $barn)
      {
          $deviceId = sprintf("BARN-%03d", $barn->barn_id);
          
          $startTime = Carbon::now()->subHour();
          $endTime = Carbon::now();

          $client = new \InfluxDB2\Client([
              "url" => env('INFLUXDB_URL'),
              "token" => env('INFLUXDB_TOKEN'),
              "org" => env('INFLUXDB_ORG'),
              "bucket" => env('INFLUXDB_BUCKET'),
          ]);

          $queryApi = $client->createQueryApi();

          $query = 'from(bucket:"' . env('INFLUXDB_BUCKET') . '")
              |> range(start: ' . $startTime->format('Y-m-d\TH:i:s\Z') . ', stop: ' . $endTime->format('Y-m-d\TH:i:s\Z') . ')
              |> filter(fn: (r) => r["_measurement"] == "barn_environment")
              |> filter(fn: (r) => r["barn_id"] == "' . $deviceId . '")
              |> filter(fn: (r) => r["_field"] == "temperature" or r["_field"] == "humidity")
              |> keep(columns: ["_time", "_value", "_field"])
              |> group(columns: ["_field"])
              |> distinct(column: "_value")
              |> sort(columns: ["_time"])';

          $temperatureData = [
              'timestamps' => [],
              'values' => []
          ];
          
          $humidityData = [
              'timestamps' => [],
              'values' => []
          ];

          try {
              $result = $queryApi->query($query);
              
              $processedTemp = [];
              $processedHum = [];
              
              foreach ($result as $table) {
                  foreach ($table->records as $record) {
                      $field = $record->values['_field'];
                      $value = floatval($record->values['_value']);
                      $timestamp = Carbon::parse($record->values['_start'])->format('H:i');
                      
                      $dataPoint = $timestamp . '_' . $value;
                      
                      if ($field === 'temperature' && !isset($processedTemp[$dataPoint])) {
                          $temperatureData['timestamps'][] = $timestamp;
                          $temperatureData['values'][] = round($value, 2);
                          $processedTemp[$dataPoint] = true;
                      } elseif ($field === 'humidity' && !isset($processedHum[$dataPoint])) {
                          $humidityData['timestamps'][] = $timestamp;
                          $humidityData['values'][] = round($value, 2);
                          $processedHum[$dataPoint] = true;
                      }
                  }
              }

              array_multisort($temperatureData['timestamps'], SORT_ASC, $temperatureData['values']);
              array_multisort($humidityData['timestamps'], SORT_ASC, $humidityData['values']);

          } catch (\Exception $e) {
              \Log::error('InfluxDB Query Error:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
              return response()->json(['error' => $e->getMessage()], 500);
          }

          return response()->json([
              'temperature' => $temperatureData,
              'humidity' => $humidityData
          ]);
      }

}

