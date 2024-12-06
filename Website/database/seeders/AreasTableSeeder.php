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
        DB::table('farm_areas')->insert([
            [
                'area_name' => 'Vinh Long GoatModel FarmModel',
                'description' => 'A farm located in Vinh Long province, specializing in goat breeding.',
                'zone_id' => 1,
                'farm_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [


                'area_name' => 'Tien Giang GoatModel FarmModel',
                'description' => 'A goat farm located in Tien Giang province.',
                'zone_id' => 1,
                'farm_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'area_name' => 'Ben Tre GoatModel FarmModel',
                'description' => 'A well-known goat farm located in Ben Tre.',
                'zone_id' => 1,
                'farm_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'area_name' => 'Vùng Chăn Nuôi',
                'description' => '',
                'zone_id' => 2,
                'farm_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

?>
