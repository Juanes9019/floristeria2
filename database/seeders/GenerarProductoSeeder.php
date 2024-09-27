<?php

namespace Database\Seeders;

use App\Models\GenerarProducto;
use App\Models\Insumo;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class GenerarProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('generar_productos')->insert([
            'nombre' => 'Arreglo #1',
            'id_insumo' => 1,
            
        ]);
        
    }
}
