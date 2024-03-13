<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Request $request)    
    {

            // Guardar la ruta del archivo en la base de datos

            DB::table('productos')->insert([
                'id_categoria' => 1,
                'precio' => 2000,
                'descripcion' => 'Este hermoso arreglo floral sirve para cualquier ocasion',
                'imagen' => 'www.floristeria_latata.web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('productos')->insert([
                'id_categoria' => 2,
                'precio' => 5000,
                'descripcion' => 'Este hermoso arreglo floral sirve para cualquier ocasion',
                'imagen' => 'www.floristeria_latata.web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('productos')->insert([
                'id_categoria' => 3,
                'precio' => 4000,
                'descripcion' => 'Este hermoso arreglo floral sirve para cualquier ocasion',
                'imagen' => 'www.floristeria_latata.web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
