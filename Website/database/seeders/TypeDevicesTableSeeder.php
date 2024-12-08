<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_devices')->insert([
            [
                'type_device_code' => 'ESP32',
                'type_device_name' => 'ESP32',
            ],
            [
                'type_device_code' => 'ESP8266',
                'type_device_name' => 'ESP8266',
            ],
        ]);
    }
}
