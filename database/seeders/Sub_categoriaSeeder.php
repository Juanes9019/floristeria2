<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Sub_categoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sub_categorias')->insert([
            'nombre' => 'Flores',
        ]);

        DB::table('sub_categorias')->insert([
            'nombre' => 'Comida',
        ]);

        DB::table('sub_categorias')->insert([
            'nombre' => 'Accesorios',
        ]);

        DB::table('sub_categorias')->insert([
            'nombre' => 'Ninguno',
        ]);
    }
}
