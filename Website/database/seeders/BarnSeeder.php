<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BarnModel;
use Illuminate\Support\Facades\DB;

class BarnSeeder extends Seeder
{
    public function run()
    {
        BarnModel::create([
            'area_id' => 1, // Livestock Zone của Vinh Long Goat Farm
            'barn_name' => 'BarnModel A',
            'location' => 'North Corner of Livestock Zone',
            'description' => 'Main barn for adult goats.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        BarnModel::create([
            'area_id' => 1,
            'barn_name' => 'BarnModel B',
            'location' => 'South Corner of Livestock Zone',
            'description' => 'BarnModel for young goats.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        BarnModel::create([
            'area_id' => 3, // Equipment Zone của Tien Giang Goat Farm
            'barn_name' => 'Equipment Storage',
            'location' => 'East Corner',
            'description' => 'Storage for larger equipment and machinery.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        BarnModel::create([
            'area_id' => 4, // Equipment Zone của Tien Giang Goat Farm
            'barn_name' => 'Equipment Storage',
            'location' => 'East Corner',
            'description' => 'Storage for larger equipment and machinery.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        // BarnModel::create([
        //     'zone_id' => 3, // Equipment Zone của Tien Giang Goat Farm
        //     'barn_name' => 'Equipment Storage4',
        //     'location' => 'East Corner4',
        //     'description' => 'Storage4 for larger equipment and machinery.',
        // ]);
    }
}
