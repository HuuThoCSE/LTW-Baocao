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
                'breed_id'=> 1,
                'breed_name' => 'Saanen',
                'description' => 'A dairy breed with high milk yield.'
            ],
            [
                'breed_id' =>2,
                'breed_name' => 'Boer', 
                'description' => 'A large meat-producing breed.'
            ],
            [   'breed_id' =>3,
                'breed_name' => 'Nubian', 
                'description' => 'A breed known for its milk production.'
            ],
            [
                'breed_id' =>4,
                'breed_name' => 'Alpine', 
                'description' => 'Goat breed has good health, high fertility and is raised for milk.
'
            ],
            [
                'breed_id' =>5,
                'breed_name' => 'Anglo-Nubian', 
                'description' => 'Hybrid goat breed. The milk has a high fat content.'
            ],
            [
                'breed_id' =>6,
                'breed_name' => 'LaMancha', 
                'description' => 'LaMancha goats give milk that is of high quality and easy to care for.'
            ],
            [
                'breed_id' =>7,
                'breed_name' => 'Bách Thảo', 
                'description' => 'Bach Thao goats can give both meat and milk, but are mainly raised for milk.'
            ],
            [
                'breed_id' =>8,
                'breed_name' => 'Cỏ', 
                'description' => 'Good adaptability to harsh natural conditions and few diseases. They are easy to raise and require little care.
'
            ],
        ]);
    }
}
