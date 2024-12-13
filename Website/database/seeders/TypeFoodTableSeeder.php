<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeFoodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('type_foods')->insert([
            [
                'type_food_code' => 'FT001',
                'type_food_name_vn' => 'Thức ăn thô xanh',
                'type_food_name_el' => 'Raw green food',
             
            ],
            [
                'type_food_code' => 'FT002',
                'type_food_name_vn' => 'Thức ăn thô khô',
                'type_food_name_el' => 'Dry raw food',
              
            ],
            [
                'type_food_code' => 'FT003',
                'type_food_name_vn' => 'Thức ăn tinh',
                'type_food_name_el' => 'Pure food',
               
            ],
            [
                'type_food_code' => 'FT004',
                'type_food_name_vn' => ' Thức ăn bổ sung',
                'type_food_name_el' => 'Supplemental food',
          
            ],
            [
                'type_food_code' => 'FT005',
                'type_food_name_vn' => 'Thức ăn chế biến công nghiệp',
                'type_food_name_el' => 'Industrial processed food',
         
            ],

        ]);
        
    }
}
