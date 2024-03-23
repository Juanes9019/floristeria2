<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventario')->insert([
            'id_producto' => 1,
            'cantidad' => 10, 
        ]);

        DB::table('inventario')->insert([
            'id_producto' => 2,
            'cantidad' => 10, 
        ]);

        DB::table('inventario')->insert([
            'id_producto' => 3,
            'cantidad' => 10, 
        ]);

        DB::table('inventario')->insert([
            'id_producto' => 4,
            'cantidad' => 10, 
        ]);

        DB::table('inventario')->insert([
            'id_producto' => 5,
            'cantidad' => 10, 
        ]);
    }
}
