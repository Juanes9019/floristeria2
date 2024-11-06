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

        $adminRoleId = DB::table('roles')->where('nombre', 'Admin')->value('id');
        $clienteRoleId = DB::table('roles')->where('nombre', 'Cliente')->value('id');
        $managerRoleId = DB::table('roles')->where('nombre', 'Manager')->value('id');
        $repartidorRoleId = DB::table('roles')->where('nombre', 'Repartidor')->value('id');

        DB::table('users')->insert([
            'name' => 'Admin ',
            'surname' => 'Admin User',
            'email' => 'admin@correo.com',
            'celular' => '3105078912',
            'id_rol' => $adminRoleId,            
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Cliente ',
            'surname' => 'Cliente User',
            'email' => 'cliente@correo.com',
            'celular' => '3105078912',
            'id_rol' => $clienteRoleId,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Manager ',
            'surname' => 'Manager User',
            'email' => 'manager@correo.com',
            'celular' => '3105078912',
            'id_rol' => $managerRoleId,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Repartidor ',
            'surname' => 'Repartidor User',
            'email' => 'repartidor@correo.com',
            'celular' => '3105078912',
            'id_rol' => $repartidorRoleId,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);        

    }
}
