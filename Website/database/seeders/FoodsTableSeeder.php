<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class FoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'food_code' => 'FOOD001',
                'food_name_vn' => 'Cỏ tươi',
                'food_name_el'=> 'Fresh Grass',
                'expiry_date' => '1-2 ngày (nếu không bảo quản trong tủ lạnh, cỏ tươi sẽ nhanh hư hỏng)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_code' => 'FOOD002',
                'food_name_vn' => 'Cỏ khô',
                'food_name_el'=> 'Dry Grass',
                'expiry_date' => '6 tháng - 1 năm (Nếu được bảo quản ở nơi khô ráo, thoáng mát)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'food_code' => 'FOOD003',
                'food_name_vn' => 'Cám ngô',
                'food_name_el'=> 'Corn Bran',
                'expiry_date' => '6 tháng - 1 năm (nếu bảo quản trong bao bì kín, nơi khô ráo)',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
