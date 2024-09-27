<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permisos')->insert([
            ['nombre' => 'dashboard'],
            ['nombre' => 'usuarios'],
            ['nombre' => 'roles'],
            ['nombre' => 'proveedores'],
            ['nombre' => 'categorias_productos'],
            ['nombre' => 'categoria_insumos'],
            ['nombre' => 'insumos'],
            ['nombre' => 'productos'],
            ['nombre' => 'compras'],
            ['nombre' => 'detalle_venta'],
            ['nombre' => 'pedidos'],
            ['nombre' => 'pqrs'],
        ]);
    }
}
