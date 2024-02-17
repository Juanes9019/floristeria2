<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin ',
            'surname' => 'Admin User',
            'email' => 'admin@correo.com',
            'celular' => '3105078912',
            'direccion' => 'CR10 #12-21',
            'type' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Cliente ',
            'surname' => 'Cliente User',
            'email' => 'cliente@correo.com',
            'celular' => '3105078912',
            'direccion' => 'CR10 #12-21',
            'type' => 0,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

    }
}
