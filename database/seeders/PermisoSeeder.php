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
            ['nombre' => 'Envio'],
        ]);

        DB::table('insumos_producto')->insert([
            [
                'id_insumo' => 1, 
                'id_producto' => 1, 
                'cantidad_usada' => 5,
            ],
            [
                'id_insumo' => 2, // Orquídeas
                'id_producto' => 1, // Arreglo floral 1
                'cantidad_usada' => 3,
            ],
            [
                'id_insumo' => 3, // Gerberas
                'id_producto' => 2, // Arreglo floral 2
                'cantidad_usada' => 7,
            ],
            [
                'id_insumo' => 4, // Tulipán
                'id_producto' => 3, // Arreglo floral 3
                'cantidad_usada' => 6,
            ],
            [
                'id_insumo' => 1, // Clavel
                'id_producto' => 2, // Arreglo floral 2
                'cantidad_usada' => 4,
            ],
            [
                'id_insumo' => 3, // Gerberas
                'id_producto' => 3, // Arreglo floral 3
                'cantidad_usada' => 8,
            ],
            [
                'id_insumo' => 3, // Gerberas
                'id_producto' => 4, // Arreglo floral 4
                'cantidad_usada' => 8,
            ],
        ]);
    }
}
