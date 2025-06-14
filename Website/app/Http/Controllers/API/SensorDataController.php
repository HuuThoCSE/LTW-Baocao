<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\InfluxDBService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SensorDataController extends Controller
{
    protected $influxDB;

    public function __construct(InfluxDBService $influxDB)
    {
        $this->influxDB = $influxDB;
    }

    /**
     * Lấy dữ liệu sensor trong 24h gần nhất
     */
    public function index(Request $request)
    {
        try {
            // Validate input parameters
            $validator = Validator::make($request->all(), [
                'start' => 'nullable|date',
                'end' => 'nullable|date',
                'barn_id' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Lấy thời gian từ request hoặc mặc định và chuyển về múi giờ local
            $endTime = $request->input('end') 
                ? Carbon::parse($request->input('end'))->setTimezone('Asia/Ho_Chi_Minh') 
                : Carbon::now('Asia/Ho_Chi_Minh');
            
            $startTime = $request->input('start') 
                ? Carbon::parse($request->input('start'))->setTimezone('Asia/Ho_Chi_Minh')
                : $endTime->copy()->subHours(24);
            
            $barnId = $request->input('barn_id', 'BARN-001');

            // Log thời gian truy vấn để debug
            Log::debug('Query time range:', [
                'start' => $startTime->format('Y-m-d H:i:s'),
                'end' => $endTime->format('Y-m-d H:i:s'),
            ]);

            // Cập nhật query với thời gian UTC cho InfluxDB
            $query = 'from(bucket: "' . config('services.influxdb.bucket') . '")
                |> range(start: ' . $startTime->utc()->format('Y-m-d\TH:i:s\Z') . ', stop: ' . $endTime->utc()->format('Y-m-d\TH:i:s\Z') . ')
                |> filter(fn: (r) => r["_measurement"] == "barn_environment")
                |> filter(fn: (r) => r["barn_id"] == "' . $barnId . '")
                |> filter(fn: (r) => r["_field"] == "humidity" or r["_field"] == "light" or r["_field"] == "temperature" or r["_field"] == "nh3")
                |> aggregateWindow(every: 5m, fn: mean, createEmpty: false)
                |> yield(name: "mean")';

            $data = $this->influxDB->query($query);

            // Khởi tạo mảng kết quả với các mảng con rỗng
            $result = [
                'timestamps' => [],
                'temperatures' => [],
                'humidity' => [],
                'light' => [],
                'nh3' => []
            ];

            // Tạo một mảng tạm để lưu trữ và tổ chức dữ liệu
            // Cấu trúc: $tempData[timestamp] = ['temp' => value, 'hum' => value, 'light' => value]
            $tempData = [];
            foreach ($data as $record) {
                // Chuyển đổi timestamp về múi giờ Việt Nam và định dạng giờ:phút
                $timestamp = Carbon::parse($record->getTime())
                    ->setTimezone('Asia/Ho_Chi_Minh')
                    ->format('H:i');
                
                $field = $record->getField();
                $value = round((float)$record->getValue(), 2);
                
                // Khởi tạo mảng cho timestamp nếu chưa tồn tại
                // Gán giá trị null cho tất cả các trường để đảm bảo có dữ liệu
                if (!isset($tempData[$timestamp])) {
                    $tempData[$timestamp] = [
                        'temp' => null,
                        'hum' => null,
                        'light' => null
                    ];
                }
                
                // Lưu giá trị vào đúng trường của timestamp
                $tempData[$timestamp][$field] = $value;
            }

            // Sắp xếp mảng theo timestamp (key của mảng)
            ksort($tempData);

            // Chuyển dữ liệu từ mảng tạm sang mảng kết quả cuối cùng
            // Đảm bảo tất cả các mảng có cùng kích thước
            foreach ($tempData as $timestamp => $values) {
                $result['timestamps'][] = $timestamp;
                $result['temperatures'][] = $values['temperature'] ?? null;  // Nếu không có giá trị thì gán null
                $result['humidity'][] = $values['humidity'] ?? null;      // Sử dụng null coalescing operator (??)
                $result['light'][] = $values['light'] ?? null;
                $result['nh3'][] = $values['nh3'] ?? null;
            }

            // Bỏ array_multisort vì dữ liệu đã được sắp xếp bởi ksort()

            // Thêm thông tin thời gian truy vấn vào response
            $result['query_info'] = [
                'start_time' => $startTime->format('Y-m-d H:i:s'),
                'end_time' => $endTime->format('Y-m-d H:i:s'),
                'timezone' => 'Asia/Ho_Chi_Minh'
            ];

            return response()->json($result);

        } catch (\Exception $e) {
            Log::error('Error in sensor data fetch:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Có lỗi xảy ra khi lấy dữ liệu',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Nhận dữ liệu từ sensor và ghi vào InfluxDB
     */
    public function store(Request $request)
    {
        Log::info('Nhận được request ghi dữ liệu sensor', [
            'data' => $request->all()
        ]);

        try {
            $payload = json_decode($request->input('payload'), true);
            if (!$payload) {
                throw new \Exception('Invalid JSON payload');
            }

            // Chuẩn bị dữ liệu để validate
            $data = [
                'measurement' => 'barn_environment',
                'tags' => [
                    'barn_id' => $payload['barn_id'] ?? 'BARN-001'
                ],
                'fields' => [
                    'temp' => $payload['temp'] ?? null,
                    'hum' => $payload['hum'] ?? null,
                ],
                'timestamp' => date('Y-m-d\TH:i:s\Z', $request->input('publish_received_at') / 1000),
            ];

            // Validate dữ liệu
            $validator = Validator::make($data, [
                'measurement' => 'required|string',
                'tags.barn_id' => 'required|string',
                'fields.temp' => 'required|numeric',
                'fields.hum' => 'required|numeric',
                'timestamp' => 'required|date',
            ]);

            if ($validator->fails()) {
                Log::warning('Validation thất bại cho request sensor', [
                    'errors' => $validator->errors()->toArray(),
                    'input' => $data
                ]);
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Xử lý timestamp
            $timestamp = new \DateTime($data['timestamp']);
            if ($timestamp > new \DateTime()) {
                $timestamp = new \DateTime();
            }
            
            $this->influxDB->writeData(
                $data['measurement'],
                $data['tags'],
                $data['fields'],
                $timestamp
            );

            // Log khi ghi dữ liệu thành công
            Log::info('Ghi dữ liệu vào InfluxDB thành công', [
                'measurement' => $data['measurement'],
                'tags' => $data['tags'],
                'fields' => $data['fields'],
                'timestamp' => $timestamp
            ]);

            return response()->json(['message' => 'Dữ liệu đã được ghi thành công vào InfluxDB'], 201);

        } catch (\Exception $e) {
            Log::error('Lỗi khi ghi dữ liệu vào InfluxDB: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Có lỗi xảy ra khi ghi dữ liệu',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}
