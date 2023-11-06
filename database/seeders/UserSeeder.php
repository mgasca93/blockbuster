<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'firstname'     => 'Mario Aurelio',
            'lastname'      => 'Gasca López',
            'slug'          => 'mario-aurelio-gasca-lopez',
            'email'         => 'hola@mariogasca.com',
            'password'      => Hash::make('password')
        ]);
        User::create([
            'firstname'     => 'Ricardo Daniel',
            'lastname'      => 'Gasca López',
            'slug'          => 'ricardo-daniel-gasca-lopez',
            'email'         => 'hola@ricardogasca.com',
            'password'      => Hash::make('password')
        ]);
        User::create([
            'firstname'     => 'Aurelio',
            'lastname'      => 'Gasca Carrillo',
            'slug'          => 'aurelio-gasca-carrillo',
            'email'         => 'aurelio.gasca.carrillo@gmail.com',
            'password'      => Hash::make('password')
        ]);
        User::create([
            'firstname'     => 'Reyna Esmeralda',
            'lastname'      => 'Dominguez Trujillo',
            'slug'          => 'reyna-esmeralda-dominguez-trujillo',
            'email'         => 'rdominguez@gmail.com',
            'password'      => Hash::make('password')
        ]);
        User::create([
            'firstname'     => 'Jospeh Nikolay',
            'lastname'      => 'Gasca Dominguez',
            'slug'          => 'joseph-nikolay-gasca-dominguez',
            'email'         => 'joseph.nikolay.gasca@gmail.com',
            'password'      => Hash::make('password')
        ]);
    }
}
