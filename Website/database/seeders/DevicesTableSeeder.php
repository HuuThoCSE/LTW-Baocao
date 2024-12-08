<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('farm_devices')->insert([
            [
                'type_device_id' => 1,
                'device_name' => 'ESP32-01',
                'farm_id' => 1,
            ],
            [
                'type_device_id' => 2,
                'device_name' => 'ESP8266-01',
                'farm_id' => 1,
            ],
        ]);
    }
}
