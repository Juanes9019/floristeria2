<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedores')->insert([
            'nombre' => 'soluciones.S.A.',
            'telefono' => '3215678913',
            'correo' => 'soluciones@correo.com',
            'ubicacion' => 'Cra 66 #49 - 01 · 305 4829049',
        ]);

        DB::table('proveedores')->insert([
            'nombre' => 'Paradise citrus',
            'telefono' => '3007612876',
            'correo' => 'Paradise@correo.com',
            'ubicacion' => 'Cra. 70 #43 - 31 · 305 4829148',
        ]);
    }
}
