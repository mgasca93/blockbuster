<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Role::truncate();
        DB::statement('TRUNCATE permissions');
        DB::statement('TRUNCATE model_has_roles');
        DB::statement('TRUNCATE model_has_permissions');
        DB::statement('TRUNCATE role_has_permissions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $user = Role::create([
            'name'          => 'General User',
            'guard_name'    => 'web'
        ]);
        $root = Role::create([
            'name'          => 'Super Admin',
            'guard_name'    => 'web'
        ]);

        Permission::create([ 'name' => 'api.users.index',   'guard_name'    => 'web'])->assignRole([ $root ]);
        Permission::create([ 'name' => 'api.users.store',   'guard_name'    => 'web'])->assignRole([ $root ]);
        Permission::create([ 'name' => 'api.users.show',    'guard_name'    => 'web'])->assignRole([ $user, $root ]);
        Permission::create([ 'name' => 'api.users.update',  'guard_name'    => 'web'])->assignRole([ $root ]);
        Permission::create([ 'name' => 'api.users.destroy', 'guard_name'    => 'web'])->assignRole([ $root ]);
    }
}
