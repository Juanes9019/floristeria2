<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Permiso_RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 1,
        ]);
        
        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 2,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 3,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 4,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 5,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 6,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 7,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 8,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 9,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 10,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 11,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 1,
            'id_permiso' => 12,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 1,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 2,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 4,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 7,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 8,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 9,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 10,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 11,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 3,
            'id_permiso' => 12,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 4,
            'id_permiso' => 1,
        ]);

        DB::table('permisos_rol')->insert([
            'id_rol' => 4,
            'id_permiso' => 11,
        ]);
    }
}
