<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Categoria_Producto_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias_productos')->insert([
            'nombre' => 'Feliz cumpleaños ',
        ]);

        DB::table('categorias_productos')->insert([
            'nombre' => 'Feliz navidad ',
        ]);

        DB::table('categorias_productos')->insert([
            'nombre' => 'Dia de la madre',
        ]);

        DB::table('categorias_productos')->insert([
            'nombre' => 'Ocasiones especiales ',
        ]);
    }
}
