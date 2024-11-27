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
            ['role_name' => 'administrator'],
            ['role_name' => 'admin'],
            ['role_name' => 'it'],
            ['role_name' => 'farmer'],
            ['role_name' => 'user'],
        ]);
    }
}
