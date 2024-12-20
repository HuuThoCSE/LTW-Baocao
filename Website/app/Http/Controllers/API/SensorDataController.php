<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class SensorDataController extends Controller
{
    protected $influxDB;

    public function __construct(InfluxDBService $influxDB)
    {
        $this->influxDB = $influxDB;
    }

    /**
     * Nhận dữ liệu từ sensor và ghi vào InfluxDB
     *s
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        // Validate đầu vào
        $validator = Validator::make($request->all(), [
            'measurement' => 'required|string',
            'tags' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $this->influxDB->readData(
                $request->input('measurement'),
                $request->input('tags', [])
            );
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Có lỗi xảy ra khi đọc dữ liệu',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        Log::info('Nhận được request ghi dữ liệu sensor', [
            'data' => $request->all()
        ]);

        try {
            // Decode payload từ JSON string thành array
            $payload = json_decode($request->input('payload'), true);
            if (!$payload) {
                throw new \Exception('Invalid JSON payload');
            }

            // Chuẩn bị dữ liệu để validate
            $data = [
                'measurement' => $payload['measurement'] ?? null,
                'fields' => [
                    'temp' => $payload['temp'] ?? null,
                    'hum' => $payload['hum'] ?? null,
                    // Thêm các trường khác nếu cần
                ],
                'timestamp' => date('Y-m-d\TH:i:s\Z', $request->input('publish_received_at') / 1000),
            ];

            // Validate dữ liệu đã được transform
            $validator = Validator::make($data, [
                'measurement' => 'required|string',
                'fields' => 'required|array',
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
            // Đảm bảo timestamp không nằm trong tương lai
            if ($timestamp > new \DateTime()) {
                $timestamp = new \DateTime();
            }
            
            $this->influxDB->writeData(
                $data['measurement'],
                $data['tags'] ?? [],
                $data['fields'],
                $timestamp
            );

            // Log khi ghi dữ liệu thành công
            Log::info('Ghi dữ liệu vào InfluxDB thành công', [
                'measurement' => $data['measurement'],
                'tags' => $data['tags'] ?? [],
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
                'detail' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }
}
