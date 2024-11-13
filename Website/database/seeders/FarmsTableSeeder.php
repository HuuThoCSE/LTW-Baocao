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
                'farm_name' => 'Vinh Long Goat Farm',
                'location' => 'Vinh Long Province',
                'owner_id' => 1
            ],
            [
                'farm_id' => 2,
                'farm_name' => 'Tien Giang Goat Farm',
                'location' => 'Tien Giang Province',
                'owner_id' => 2
            ],
            [
                'farm_id' => 3,
                'farm_name' => 'Ben Tre Goat Farm',
                'location' => 'Ben Tre Province',
                'owner_id' => 3
            ]
        ]);
    }
}
