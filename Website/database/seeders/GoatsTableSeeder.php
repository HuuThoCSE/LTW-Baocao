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
                'goat_name' => 'Billy',
                'goat_age' => 2,
                'farm_id' => 1,
                'breed_id' => 1,
                'origin' => 'imported' // Dê này là dê được nhập
            ],
            [
                'goat_name' => 'Molly',
                'goat_age' => 1,
                'farm_id' => 1,
                'breed_id' => 2,
                'origin' => 'born_on_farm' // Dê này sinh tại nông trại
            ]
        ]);
    }
}
