<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barn;
use Illuminate\Support\Facades\DB;

class BarnSeeder extends Seeder
{
    public function run()
    {
        Barn::create([
            'area_id' => 1, // Livestock Zone của Vinh Long Goat Farm
            'barn_name' => 'Barn A',
            'location' => 'North Corner of Livestock Zone',
            'description' => 'Main barn for adult goats.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        Barn::create([
            'area_id' => 1,
            'barn_name' => 'Barn B',
            'location' => 'South Corner of Livestock Zone',
            'description' => 'Barn for young goats.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        Barn::create([
            'area_id' => 3, // Equipment Zone của Tien Giang Goat Farm
            'barn_name' => 'Equipment Storage',
            'location' => 'East Corner',
            'description' => 'Storage for larger equipment and machinery.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        Barn::create([
            'area_id' => 4, // Equipment Zone của Tien Giang Goat Farm
            'barn_name' => 'Equipment Storage',
            'location' => 'East Corner',
            'description' => 'Storage for larger equipment and machinery.',
            'farm_id' => 1,
            'capacity' => 5,
        ]);

        // Barn::create([
        //     'zone_id' => 3, // Equipment Zone của Tien Giang Goat Farm
        //     'barn_name' => 'Equipment Storage4',
        //     'location' => 'East Corner4',
        //     'description' => 'Storage4 for larger equipment and machinery.',
        // ]);
    }
}
