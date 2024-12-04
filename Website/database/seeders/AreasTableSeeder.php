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
                'name' => 'Vinh Long Goat Farm',
                'description' => 'A farm located in Vinh Long province, specializing in goat breeding.',
                'zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [


                'name' => 'Tien Giang Goat Farm',
                'description' => 'A goat farm located in Tien Giang province.',
                'zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'name' => 'Ben Tre Goat Farm',
                'description' => 'A well-known goat farm located in Ben Tre.',
                'zone_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'name' => 'Vùng Chăn Nuôi',
                'description' => '',
                'zone_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

?>
