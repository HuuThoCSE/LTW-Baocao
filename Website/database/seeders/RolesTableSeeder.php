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
        DB::table('farm_roles')->insert([
            ['role_name' => 'administrator'],
            ['role_name' => 'farm_owner'],
            ['role_name' => 'farm_it'],
            ['role_name' => 'farmer'],
            ['role_name' => 'regular_user'],
        ]);
    }
}
