<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            FarmsTableSeeder::class,
        ]);

        // Thêm dữ liệu vào bảng roles
        DB::table('farm_roles')->insert([
            ['role_name' => 'administrator'],
            ['role_name' => 'farm_owner'],
            ['role_name' => 'it_farm'],
            ['role_name' => 'farmer'],
            ['role_name' => 'user'],
        ]);

        // Thêm dữ liệu vào bảng permissions
        DB::table('permissions')->insert([
            ['permission_name' => 'view_farm_list'],
            ['permission_name' => 'edit_farm_list'],
            ['permission_name' => 'view_goat_list'],
            ['permission_name' => 'edit_goat_list'],
            ['permission_name' => 'view_device'],
            ['permission_name' => 'edit_device'],
            ['permission_name' => 'view_dashboard'],
            ['permission_name' => 'edit_medication'],
            ['permission_name' => 'view_settings'],
        ]);

        // Liên kết các quyền với vai trò trong bảng permission_role
        // Ví dụ: administrator có tất cả quyền
        $adminRole = DB::table('farm_roles')->where('role_name', 'administrator')->first();
        $permissions = DB::table('permissions')->pluck('permission_id');

        foreach ($permissions as $permissionId) {
            DB::table('permission_role')->insert([
                'role_id' => $adminRole->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        // Ví dụ: farm_owner có quyền quản lý farm và goat, nhưng không có quyền edit settings
        $farmOwnerRole = DB::table('farm_roles')->where('role_name', 'farm_owner')->first();
        $farmOwnerPermissions = [
            'view_farm_list', 'edit_farm_list', 'view_goat_list', 'edit_goat_list', 'view_dashboard'
        ];

        foreach ($farmOwnerPermissions as $permissionName) {
            $permissionId = DB::table('permissions')->where('permission_name', $permissionName)->first()->permission_id;
            DB::table('permission_role')->insert([
                'role_id' => $farmOwnerRole->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        // Giới hạn quyền của IT Farm
        $itFarmRole = DB::table('farm_roles')->where('role_name', 'it_farm')->first();
        $itFarmPermissions = [
            'view_device', 'edit_device', 'view_dashboard', 'view_farm_list'
        ];

        foreach ($itFarmPermissions as $permissionName) {
            $permissionId = DB::table('permissions')->where('permission_name', $permissionName)->first()->permission_id;
            DB::table('permission_role')->insert([
                'role_id' => $itFarmRole->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        // Giới hạn quyền của Farmer
        $farmerRole = DB::table('farm_roles')->where('role_name', 'farmer')->first();
        $farmerPermissions = [
            'view_farm_list', 'view_goat_list', 'view_dashboard'
        ];

        foreach ($farmerPermissions as $permissionName) {
            $permissionId = DB::table('permissions')->where('permission_name', $permissionName)->first()->permission_id;
            DB::table('permission_role')->insert([
                'role_id' => $farmerRole->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        // Giới hạn quyền của User
        $userRole = DB::table('farm_roles')->where('role_name', 'user')->first();
        $userPermissions = [
            'view_farm_list', 'view_goat_list'
        ];

        foreach ($userPermissions as $permissionName) {
            $permissionId = DB::table('permissions')->where('permission_name', $permissionName)->first()->permission_id;
            DB::table('permission_role')->insert([
                'role_id' => $userRole->role_id,
                'permission_id' => $permissionId,
            ]);
        }

        $accounts = [
            [
                'user_name' => 'Administrator',
                'user_email' => 'admin@farm.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 1,
            ],
            [
                'user_name' => 'Admin Farm 1',
                'user_email' => 'admin@farm1.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 2,
            ],
            [
                'user_name' => 'IT Farm 1',
                'user_email' => 'it@farm1.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 3,
            ],
            [
                'user_name' => 'Farmer 1',
                'user_email' => 'farmer1@farm1.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 4,
            ],
            [
                'user_name' => 'User 1',
                'user_email' => 'user1@farm1.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 1,
                'role_id' => 5,
            ],
            [
                'user_name' => 'Admin farm 2',
                'user_email' => 'admin@farm2.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 2,
                'role_id' => 5,
            ],
            [
                'user_name' => 'Admin farm 3',
                'user_email' => 'admin@farm3.vn',
                'user_password' => bcrypt('123456'),
                'farm_id' => 3,
                'role_id' => 5,
            ],
        ];

        // Dùng lệnh Eloquent để thêm nhiều tài khoản cùng lúc
        foreach ($accounts as $account) {
            User::create($account);
        }

        $this->call([
            UserOwnerFarmSeeder::class,
            ZoneSeeder::class,
            AreasTableSeeder::class,
            BarnSeeder::class,
            BreedsTableSeeder::class,
            GoatsTableSeeder::class,
            MedicationsTableSeeder::class,
            GoatWeighsTableSeeder::class,
            TypeDevicesTableSeeder::class,
            DevicesTableSeeder::class,
        ]);
    }
}
