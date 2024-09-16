<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ComestiblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('comestibles')->insert([
            'nombre' => 'Cerveza',
            'tipo' => 'bebida',
            'precio' => 4000,
        ]);
        
        DB::table('comestibles')->insert([
            'nombre' => 'Gaseosa',
            'tipo' => 'bebida',
            'precio' => 3000,
        ]);
        
        DB::table('comestibles')->insert([
            'nombre' => 'Galletas',
            'tipo' => 'comida',
            'precio' => 2500,
        ]);
        
        DB::table('comestibles')->insert([
            'nombre' => 'Pastel',
            'tipo' => 'comida',
            'precio' => 9000,
        ]);
        
    }
}
