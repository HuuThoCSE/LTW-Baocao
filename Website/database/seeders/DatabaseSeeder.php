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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@test.vn',
            'password'=> bcrypt('123456'),
            'farm_id' => 1,
            'role_id' => 1,
        ]);

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
