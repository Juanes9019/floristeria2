<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proveedores = [
            [
                'nombre' => 'Soluciones S.A.',
                'telefono' => '3215678913',
                'correo' => 'soluciones@correo.com',
                'ubicacion' => 'Cra 66 #49 - 01 · 305 4829049',
            ],
            [
                'nombre' => 'Paradise Citrus',
                'telefono' => '3007612876',
                'correo' => 'paradise@correo.com',
                'ubicacion' => 'Cra. 70 #43 - 31 · 305 4829148',
            ],
            // Puedes añadir más proveedores si quieres tener más variedad
        ];

        // Generar 48 registros adicionales de forma dinámica
        for ($i = 0; $i < 98; $i++) {
            $proveedores[] = [
                'nombre' => 'Proveedor ' . $i,
                'telefono' => '3' . rand(100000000, 999999999),
                'correo' => 'proveedor' . $i . '@correo.com',
                'ubicacion' => 'Calle ' . rand(1, 100) . ' # ' . rand(1, 100) . ' - ' . rand(1, 100),
            ];
        }

        // Insertar todos los registros en la tabla proveedores
        DB::table('proveedores')->insert($proveedores);
    }
}
