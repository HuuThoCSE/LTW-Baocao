<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GoatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('goats')->insert([
            [
                'goat_id' => 'D1',
                'goat_name' => 'Ailly',
                'goat_age' => 2,
                'farm_id' => 1,
                'breed_id' => 'B1',
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 'D2',
                'goat_name' => 'Billy',
                'goat_age' => 2,
                'farm_id' => 1,
                'breed_id' => "B2",
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 'D3',
                'goat_name' => 'Telly',
                'goat_age' => 1,
                'farm_id' => 1,
                'breed_id' => B2,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 'D4',
                'goat_name' => 'Bitelly',
                'goat_age' => 1,
                'farm_id' => 1,
                'breed_id' => B2,
                'origin' => 'born_on_farm' // Dê này sinh tại nông trại
            ],
            [
                'goat_id' => 'D5',
                'goat_name' => 'Celly',
                'goat_age' => 1,
                'farm_id' => 1,
                'breed_id' => B5,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
        ]);
    }
}
