<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            [
                'area_id' => 1,
                'area_name' => 'Vinh Long Goat Farm',
                'description' => 'A farm located in Vinh Long province, specializing in goat breeding.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [   
                'area_id' => 2,
                'area_name' => 'Tien Giang Goat Farm',
                'description' => 'A goat farm located in Tien Giang province.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [ 
                'area_id' => 3,
                'area_name' => 'Ben Tre Goat Farm',
                'description' => 'A well-known goat farm located in Ben Tre.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

?>