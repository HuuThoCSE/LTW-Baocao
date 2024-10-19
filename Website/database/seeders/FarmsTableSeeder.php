<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FarmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('farms')->insert([
            [   
                'farm_id' => 1,
                'farm_name' => 'Farm A',
                'location' => 'Area A',
                'owner_id' => 1
            ],
            [
                'farm_id' => 2,
                'farm_name' => 'Farm B',
                'location' => 'Area B',
                'owner_id' => 1
            ],
            [
                'farm_id' => 3,
                'farm_name' => 'Farm C',
                'location' => 'Area C',
                'owner_id' => 1
            ]
        ]);
    }
}
