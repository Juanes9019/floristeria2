<?php

namespace Database\Seeders;

use App\Models\Proveedor;
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
        Proveedor::create([
            'nombre' => 'Soluciones S.A.',
            'telefono' => '3215678913',
            'correo' => 'soluciones@correo.com',
            'ubicacion' => 'Cra 66 #49 - 01 · 305 4829049',
        ]);
        Proveedor::create([
            'nombre' => 'Paradise Citrus',
            'telefono' => '3007612876',
            'correo' => 'paradise@correo.com',
            'ubicacion' => 'Cra. 70 #43 - 31 · 305 4829148',
        ]);


    }
}
