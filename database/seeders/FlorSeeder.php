<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FlorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('flores')->insert([
            'nombre' => 'Clavel',
            'precio' => 3000,
        ]);
        
        DB::table('flores')->insert([
            'nombre' => 'Tulipán',
            'precio' => 8000,
        ]);
        
        DB::table('flores')->insert([
            'nombre' => 'Orquídea',
            'precio' => 15000,
        ]);
        
        DB::table('flores')->insert([
            'nombre' => 'Rosa',
            'precio' => 5000,
        ]);
    }
}
