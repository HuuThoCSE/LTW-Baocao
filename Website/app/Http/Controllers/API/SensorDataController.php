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

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'measurement' => 'required|string',
            'tags' => 'nullable|array',
            'fields' => 'required|array',
            'timestamp' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            // Thêm log khi validation thất bại
            Log::warning('Validation thất bại cho request sensor', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        try {
            // Xử lý timestamp
            $timestamp = null;
            if (isset($data['timestamp'])) {
                $timestamp = new \DateTime($data['timestamp']);
                // Đảm bảo timestamp không nằm trong tương lai
                if ($timestamp > new \DateTime()) {
                    $timestamp = new \DateTime();
                }
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
                'data' => $data
            ]);

            return response()->json([
                'error' => 'Có lỗi xảy ra khi ghi dữ liệu',
                'detail' => $e->getMessage(),
                'data' => $data
            ], 500);
        }
    }
}
