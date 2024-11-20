<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoatWeighsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goat_weighs')->insert([
            [   
               
                'goat_id' => 1,
                'weight' => 18.5,
                'created_at' => '2024-10-07 07:00:00',
                'updated_at' => '2024-10-07 07:00:00'
            ],
            [
                
                'goat_id' => 2,
                'weight' => 19.5,
                'created_at' => '2024-10-14 07:00:00',
                'updated_at' => '2024-10-14 07:00:00'
            ],
            [
          
                'goat_id' => 3,
                'weight' => 20.5,
                'created_at' => '2024-10-21 07:00:00',
                'updated_at' => '2024-10-21 07:00:00'
            ],
            [
               
                'goat_id' => 4,
                'weight' => 21.5,
                'created_at' => '2024-10-28 07:00:00',
                'updated_at' => '2024-10-28 07:00:00'
            ],
            [
                
                'goat_id' => 5,
                'weight' => 21.5,
                'created_at' => '2024-10-28 07:00:00',
                'updated_at' => '2024-10-28 07:00:00'
            ]
        ]);
    }
}
