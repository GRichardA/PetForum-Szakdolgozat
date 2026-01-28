<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
       $nevek = ['Kovács Péter', 'Nagy Anna', 'Szabó Balázs', 'Tóth Eszter', 'Kiss Gábor', 'Molnár Dóra', 'Farkas Tamás', 'Varga Júlia', 'Horváth Ádám', 'Papp Krisztina'];

    foreach ($nevek as $nev) {
        \App\Models\User::create([
            'name' => $nev,
            'email' => str()->slug($nev) . '@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
    }
}
