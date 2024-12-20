<?php

namespace App\Services;

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;
use Illuminate\Support\Facades\Log;

class InfluxDBService
{
    protected $client;
    protected $writeApi;
    protected $bucket;
    protected $org;

    public function __construct()
    {
        Log::info('InfluxDB Config', [
            'url' => config('influxdb.url'),
            'org' => config('influxdb.org'),
            'bucket' => config('influxdb.bucket')
        ]);

        $config = config('influxdb');

        $this->client = new Client([
            "url" => $config['url'],
            "token" => $config['token'],
            "org" => $config['org'],
            "bucket" => $config['bucket'],
            "precision" => WritePrecision::NS
        ]);

        $this->writeApi = $this->client->createWriteApi();
        $this->bucket = $config['bucket'];
        $this->org = $config['org'];
    }

    /**
     * Ghi một điểm dữ liệu vào InfluxDB
     *
     * @param string $measurement
     * @param array $tags
     * @param array $fields
     * @param \DateTimeInterface|null $timestamp
     * @return void
     */
    public function writeData(string $measurement, array $tags, array $fields, ?\DateTimeInterface $timestamp = null)
    {
        $point = Point::measurement($measurement);

        foreach ($tags as $key => $value) {
            $point->addTag($key, $value);
        }

        foreach ($fields as $key => $value) {
            $point->addField($key, $value);
        }

        if ($timestamp) {
            $timestampNs = $timestamp->getTimestamp() * 1000000000;
            $point->time($timestampNs);
        }

        $this->writeApi->write($point);
    }

    public function readData(string $measurement, ?array $tags = [])
    {
        $queryApi = $this->client->createQueryApi();
        
        // Xây dựng câu truy vấn Flux
        $query = 'from(bucket:"' . $this->bucket . '") 
            |> range(start: -1h)
            |> filter(fn: (r) => r["_measurement"] == "' . $measurement . '"';
        
        // Thêm điều kiện tags nếu có
        if (!empty($tags)) {
            foreach ($tags as $key => $value) {
                $query .= ' and r["' . $key . '"] == "' . $value . '"';
            }
        }
        
        $query .= ')';

        try {
            $result = $queryApi->query($query);
            
            // Chuyển đổi kết quả thành mảng
            $data = [];
            foreach ($result as $table) {
                foreach ($table->records as $record) {
                    $data[] = [
                        'time' => $record->getTime(),
                        'value' => $record->getValue(),
                        'field' => $record->getField(),
                        'measurement' => $record->getMeasurement(),
                        'tags' => $record->values
                    ];
                }
            }
            
            return $data;
        } catch (\Exception $e) {
            \Log::error('Lỗi khi đọc dữ liệu từ InfluxDB: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Đóng kết nối InfluxDB
     *
     * @return void
     */
    public function close()
    {
        $this->writeApi->close();
        $this->client->close();
    }
}
