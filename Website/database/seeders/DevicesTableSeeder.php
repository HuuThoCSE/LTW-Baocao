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
        DB::table('devices')->insert([
            [
                'device_type_id' => 1,
                'device_name' => 'ESP32-01',
            ],
            [
                'device_type_id' => 2,
                'device_name' => 'ESP8266-01',
            ],
        ]);
    }
}
