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
            'tipo_proveedor' => 'empresa',
            'numero_documento' => '4012288',
            'nombre' => 'Soluciones S.A.',
            'telefono' => '3215678913',
            'correo' => 'soluciones@correo.com',
            'ubicacion' => 'Cra 66 #49 - 01',
        ]);
        Proveedor::create([
            'tipo_proveedor' => 'empresa',
            'numero_documento' => '40484592',
            'nombre' => 'Paradise Citrus',
            'telefono' => '3007612876',
            'correo' => 'paradise@correo.com',
            'ubicacion' => 'Cra. 70 #43 - 31',
        ]);


    }
}
