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
                'farm_name' => 'Nông trại Vĩnh Long',
                'location' => 'Vinh Long Province',
            ],
            [
                'farm_name' => 'Nông trại Tiền Giang',
                'location' => 'Tien Giang Province',
            ],
            [
                'farm_name' => 'Nông trại dê Bến Tre',
                'location' => 'Ben Tre Province',
            ]
        ]);
    }
}
