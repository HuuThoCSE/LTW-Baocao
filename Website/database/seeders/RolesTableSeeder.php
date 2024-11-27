<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'administrator'],
            ['name' => 'admin'],
            ['name' => 'it'],
            ['name' => 'farmer'],
            ['name' => 'user'],
        ]);
    }
}
