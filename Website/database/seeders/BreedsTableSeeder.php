<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('breeds')->insert([
            [
                'breed_name' => 'Boer', 
                'description' => 'A large meat-producing breed.'
            ],
            [
                'breed_name' => 'Nubian', 
                'description' => 'A breed known for its milk production.'
            ],
            [
                'breed_name' => 'Saanen', 
                'description' => 'A dairy breed with high milk yield.'
                ]
        ]);
    }
}
