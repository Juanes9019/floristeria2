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
            ['nombre' => 'Dashboard'],
            ['nombre' => 'Usuarios'],
            ['nombre' => 'Roles'],
            ['nombre' => 'Proveedores'],
            ['nombre' => 'Categoria de productos'],
            ['nombre' => 'Categoria de insumos'],
            ['nombre' => 'Insumos'],
            ['nombre' => 'Productos'],
            ['nombre' => 'Compras'],
            ['nombre' => 'Venta'],
            ['nombre' => 'Pedidos'],
            ['nombre' => 'Pqrs'],
        ]);
    }
}
