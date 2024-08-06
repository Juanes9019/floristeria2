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

        //se obtienen los ids de los roles
        $adminRoleId = DB::table('roles')->where('nombre', 'Admin')->value('id');
        $clienteRoleId = DB::table('roles')->where('nombre', 'Cliente')->value('id');

        DB::table('users')->insert([
            'name' => 'Admin ',
            'surname' => 'Admin User',
            'email' => 'admin@correo.com',
            'celular' => '3105078912',
            'direccion' => 'CR10 #12-21',
            'id_rol' => $adminRoleId,            
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'name' => 'Cliente ',
            'surname' => 'Cliente User',
            'email' => 'cliente@correo.com',
            'celular' => '3105078912',
            'direccion' => 'CR10 #12-21',
            'id_rol' => $clienteRoleId,
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

    }
}
