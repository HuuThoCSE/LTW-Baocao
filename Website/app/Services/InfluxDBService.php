<?php

namespace App\Services;

use InfluxDB2\Client;
use InfluxDB2\Point;
use DateTime;
use Illuminate\Support\Facades\Log;

class InfluxDBService
{
    protected $client;
    protected $queryApi;
    protected $writeApi;
    protected $config;

    public function __construct()
    {
        // Thêm logging để debug
        Log::debug('InfluxDB ENV values:', [
            'url' => env('INFLUXDB_URL'),
            'org' => env('INFLUXDB_ORG'),
            'bucket' => env('INFLUXDB_BUCKET'),
            'has_token' => !empty(env('INFLUXDB_TOKEN'))
        ]);

        $this->config = [
            "url" => config('services.influxdb.url'),
            "token" => config('services.influxdb.token'),
            "org" => config('services.influxdb.org'),
            "bucket" => config('services.influxdb.bucket'),
        ];

        // Log cấu hình từ config
        Log::debug('InfluxDB Configuration from config:', [
            'url' => $this->config['url'],
            'org' => $this->config['org'],
            'bucket' => $this->config['bucket'],
            'has_token' => !empty($this->config['token'])
        ]);

        // Kiểm tra cấu hình
        $this->validateConfig();

        $this->client = new Client($this->config);
        $this->queryApi = $this->client->createQueryApi();
        $this->writeApi = $this->client->createWriteApi();
    }

    /**
     * Kiểm tra cấu hình InfluxDB
     *
     * @throws \Exception
     */
    protected function validateConfig()
    {
        $required = ['url', 'token', 'org', 'bucket'];
        $missing = [];

        foreach ($required as $field) {
            if (empty($this->config[$field])) {
                $missing[] = $field;
            }
        }

        if (!empty($missing)) {
            $message = 'Missing required InfluxDB configuration: ' . implode(', ', $missing);
            Log::error($message);
            throw new \Exception($message);
        }
    }

    /**
     * Thực hiện truy vấn Flux
     *
     * @param string $query
     * @return array
     */
    public function query(string $query)
    {
        try {
            Log::debug('Executing InfluxDB query', ['query' => $query]);

            $result = $this->queryApi->query($query);
            
            // Chuyển đổi kết quả thành mảng dữ liệu
            $data = [];
            foreach ($result as $table) {
                foreach ($table->records as $record) {
                    $data[] = $record;
                }
            }
            
            Log::debug('InfluxDB query result', ['count' => count($data)]);
            return $data;

        } catch (\Exception $e) {
            Log::error('InfluxDB query error', [
                'error' => $e->getMessage(),
                'query' => $query,
                'config' => [
                    'url' => $this->config['url'],
                    'org' => $this->config['org'],
                    'bucket' => $this->config['bucket']
                ]
            ]);
            throw $e;
        }
    }

    /**
     * Ghi dữ liệu vào InfluxDB
     *
     * @param string $measurement
     * @param array $tags
     * @param array $fields
     * @param DateTime|null $timestamp
     * @return void
     */
    public function writeData(string $measurement, array $tags, array $fields, ?DateTime $timestamp = null)
    {
        try {
            $point = Point::measurement($measurement);

            // Thêm tags
            foreach ($tags as $key => $value) {
                $point->addTag($key, $value);
            }

            // Thêm fields
            foreach ($fields as $key => $value) {
                if (is_numeric($value)) {
                    $point->addField($key, (float)$value);
                } else {
                    $point->addField($key, $value);
                }
            }

            // Thêm timestamp nếu có
            if ($timestamp) {
                $point->time($timestamp);
            }

            Log::debug('Writing data to InfluxDB', [
                'measurement' => $measurement,
                'tags' => $tags,
                'fields' => $fields,
                'timestamp' => $timestamp ? $timestamp->format('Y-m-d H:i:s') : null
            ]);

            // Ghi dữ liệu
            $this->writeApi->write($point);

        } catch (\Exception $e) {
            Log::error('InfluxDB write error', [
                'error' => $e->getMessage(),
                'measurement' => $measurement,
                'tags' => $tags,
                'fields' => $fields
            ]);
            throw $e;
        }
    }

    /**
     * Đóng kết nối khi service bị hủy
     */
    public function __destruct()
    {
        if ($this->client) {
            $this->client->close();
        }
    }
}
