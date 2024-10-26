<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('medications')->insert([
            [
                'medication_code' => 'MED001',
                'medication_name' => 'Paracetamol',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medication_code' => 'MED002',
                'medication_name' => 'Ibuprofen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medication_code' => 'MED003',
                'medication_name' => 'Amoxicillin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
