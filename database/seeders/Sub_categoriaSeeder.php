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
            'nombre' => 'Peluches',
        ]);

        DB::table('sub_categorias')->insert([
            'nombre' => 'Dulces',
        ]);

        DB::table('sub_categorias')->insert([
            'nombre' => 'Canastos',
        ]);
    }
}
