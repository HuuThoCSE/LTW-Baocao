<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        Zone::create([
            'farm_id' => 1, // Tien Giang GoatModel FarmModel
            'zone_name' => 'Livestock Zone',
            'description' => 'AreaModel dedicated to animal housing.',
        ]);

        Zone::create([
            'farm_id' => 1,
            'zone_name' => 'Feed Storage Zone',
            'description' => 'Storage for feed and supplies.',
        ]);

        Zone::create([
            'farm_id' => 1,
            'zone_name' => 'Breeding Zone',
            'description' => 'For mother and baby goats',
        ]);

        Zone::create([
            'farm_id' => 2, // Ben Tre GoatModel FarmModel
            'zone_name' => 'Equipment Zone',
            'description' => 'AreaModel for storing and maintaining equipment.',
        ]);
    }
}
