<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $user = Role::create([
            'name'          => 'General User',
            'guard_name'    => 'web'
        ]);

        User::create([
            'firstname'     => 'Mario Aurelio',
            'lastname'      => 'Gasca López',
            'slug'          => 'mario-aurelio-gasca-lopez',
            'email'         => 'hola@mariogasca.com',
            'password'      => Hash::make('password')
        ])->assignRole( $user );   

    }
}
