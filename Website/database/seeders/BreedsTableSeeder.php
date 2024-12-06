<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('farm_breeds')->insert([
            [
                'farm_id' => 1,
                'breed_name_eng' => 'Bách Thảo',
                'breed_name_vie' => 'Bách Thảo',
                'description' => 'Trắng, đầu nâu.',
            ],
            [
                'farm_id' => 1,
                'breed_name_eng' => 'Cỏ',
                'breed_name_vie' => 'Cỏ',
                'description' => '',
            ],
            [
                'farm_id' => 1,
                'breed_name_eng' => 'Boer lai',
                'breed_name_vie' => 'Boer lai',
                'description' => 'Màu trắng.',
            ],
            [
                'farm_id' => 1,
                'breed_name_eng' => 'Boer lửa',
                'breed_name_vie' => 'Boer lửa',
                'description' => 'Màu nâu.',
            ],
        ]);
    }
}
