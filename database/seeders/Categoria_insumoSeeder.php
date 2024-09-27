<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Categoria_insumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categoria_insumos')->insert([
            'nombre' => 'Flores',
            'id_proveedor' => 1,
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Peluches',
            'id_proveedor' => 2,
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Dulces',
            'id_proveedor' => 1,
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Bebidas',
            'id_proveedor' => 1,
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Canastos',
            'id_proveedor' => 2,
        ]);
    }
}