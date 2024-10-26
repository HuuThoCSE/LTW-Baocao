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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@test.vn',
            'password'=> bcrypt('123456'),
        ]);

        $this->call(FarmsTableSeeder::class);

        // Chạy seeder bảng breeds trước
        $this->call(BreedsTableSeeder::class);

        // Sau đó mới chạy seeder bảng goats
        $this->call(GoatsTableSeeder::class);

        $this->call(MedicationsTableSeeder::class);
    }
}
