<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('insumos')->insert([
        'id_categoria_insumo' => 1,
        'nombre' => 'Rosas',
        'cantidad_insumo' => 0,
        'costo_unitario' => 700,
        'perdida_insumo' => 0,
        'costo_perdida' => 0,
        ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Orquídeas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);
            
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Gerberas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Lirios',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Girasoles',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Azucenas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Anturios',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Aves del Paraíso',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Rosas Eternas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 2,
            'nombre' => 'Osos',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Chocolatinas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Papas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Gomitas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 4,
            'nombre' => 'Yogurt',
            'cantidad_insumo' => 0,
            'costo_unitario' => 800,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 4,
            'nombre' => 'Cervezas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 3000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Cuadrado',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Redondo',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);
            
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Vasija',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Vidrio',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);
    }
}