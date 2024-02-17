<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorias')->insert([
            'nombre' => 'Feliz cumpleaños ',
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Feliz navidad ',
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Dia de la madre',
        ]);

        DB::table('categorias')->insert([
            'nombre' => 'Ocasiones especiales ',
        ]);
    }
}
