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


                'name' => 'Vinh Long GoatModel FarmModel',
                'description' => 'A farm located in Vinh Long province, specializing in goat breeding.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [


                'name' => 'Tien Giang GoatModel FarmModel',
                'description' => 'A goat farm located in Tien Giang province.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'name' => 'Ben Tre GoatModel FarmModel',
                'description' => 'A well-known goat farm located in Ben Tre.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

?>
