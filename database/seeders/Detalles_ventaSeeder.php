<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Detalle;

class Detalles_ventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Detalle::create([
            'id_pedido' => 1,
            'id_producto' => 3,
            'precio' => 150000,
            'cantidad' => 1,
            'subtotal' => 320000,
            'imagen' => "https://i.imgur.com/ia1BeKH.png",
            'opciones' => null
        ]);

        Detalle::create([
            'id_pedido' => 1,
            'id_producto' => 2,
            'precio' => 170000,
            'cantidad' => 1,
            'subtotal' => 320000,
            'imagen' => "https://i.imgur.com/ia1BeKH.png",
            'opciones' => null
        ]);

        Detalle::create([
            'id_pedido' => 2,
            'id_producto' => 4,
            'precio' => 250000,
            'cantidad' => 1,
            'subtotal' => 250000,
            'imagen' => "https://i.imgur.com/ia1BeKH.png",
            'opciones' => null
        ]);
    }
}
