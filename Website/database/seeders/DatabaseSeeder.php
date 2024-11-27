<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(FarmsTableSeeder::class);

        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@farm.vn',
                'password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 1,
            ],
            [
                'name' => 'Admin Farm 1',
                'email' => 'admin@farm1.vn',
                'password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 2,
            ],
            [
                'name' => 'IT Farm 1',
                'email' => 'it@farm1.vn',
                'password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 3,
            ],
            [
                'name' => 'Farmer 1',
                'email' => 'farmer1@farm1.vn',
                'password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 4,
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@farm1.vn',
                'password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 5,
            ],
        ];
        
        // Dùng lệnh Eloquent để thêm nhiều tài khoản cùng lúc
        foreach ($users as $user) {
            User::factory()->create($user);
        }

        $this->call(ZoneSeeder::class);

        $this->call(BarnSeeder::class);

        // Chạy seeder bảng breeds trước
        $this->call(BreedsTableSeeder::class);

        // Sau đó mới chạy seeder bảng goats
        $this->call(GoatsTableSeeder::class);

        $this->call(MedicationsTableSeeder::class);

        $this->call(RolesTableSeeder::class);

        $this->call(GoatWeighsTableSeeder::class);

        $this->call(TypeDevicesTableSeeder::class);

        $this->call(DevicesTableSeeder::class);

        $this->call(AreasTableSeeder::class);


    }
}
