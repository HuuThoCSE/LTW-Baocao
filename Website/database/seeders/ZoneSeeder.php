<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ZoneModel;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        ZoneModel::insert([
            [
                'farm_id' => 1, // Tien Giang Goat Farm
                'zone_name' => 'Livestock Zone',
                'description' => 'Area dedicated to animal housing.',
            ],
            [
                'farm_id' => 1,
                'zone_name' => 'Feed Storage Zone',
                'description' => 'Storage for feed and supplies.',
            ],
            [
                'farm_id' => 1,
                'zone_name' => 'Breeding Zone',
                'description' => 'For mother and baby goats',
            ],
            [
                'farm_id' => 2, // Ben Tre Goat Farm
                'zone_name' => 'Equipment Zone',
                'description' => 'Area for storing and maintaining equipment.',
            ]
        ]);
    }
}
