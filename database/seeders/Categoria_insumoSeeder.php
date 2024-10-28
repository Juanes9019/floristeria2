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
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Peluches',
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Dulces',
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Bebidas',
        ]);

        DB::table('categoria_insumos')->insert([
            'nombre' => 'Canastos',
        ]);
    }
}