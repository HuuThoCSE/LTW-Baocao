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
        DB::table('farm_goats')->insert([
            [
                'goat_id' => 1,
                'goat_name' => 'Ailly',
                'goat_age' => 2,
                'farm_id' => 1,
                'breed_id' => 1,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 2,
                'goat_name' => 'Billy',
                'goat_age' => 2,
                'farm_id' => 1,
                'breed_id' => 2,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 3,
                'goat_name' => 'Telly',
                'goat_age' => 1,
                'farm_id' => 1,
                'breed_id' => 2,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_id' => 4,
                'goat_name' => 'Bitelly',
                'goat_age' => 1,
                'farm_id' => 2,
                'breed_id' => 2,
                'origin' => 'born_on_farm' // Dê này sinh tại nông trại
            ],
            [
                'goat_id' => 5,
                'goat_name' => 'Celly',
                'goat_age' => 1,
                'farm_id' => 3,
                'breed_id' => 3,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
        ]);
    }
}
