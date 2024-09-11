<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AccesoriosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accesorios')->insert([
            'nombre' => 'Peluches',
            'precio' => 45000,
        ]);
        
        DB::table('accesorios')->insert([
            'nombre' => 'Cartas',
            'precio' => 4500,
        ]);
        
        DB::table('accesorios')->insert([
            'nombre' => 'Globos',
            'precio' => 2000,
        ]);
        
    }
}
