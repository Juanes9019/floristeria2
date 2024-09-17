<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ColoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/PLbh3p6.png', 
            'id_flor' => 1, 
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Rosado',
            'imagen' => 'https://i.imgur.com/F3KjnwJ.jpeg', 
            'id_flor' => 1,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/ihurqZn.png', 
            'id_flor' => 1,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/NkIcRVK.png', 
            'id_flor' => 2,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Morado',
            'imagen' => 'https://i.imgur.com/wkTkKas.jpeg', 
            'id_flor' => 2,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/lIpVzYT.png',
            'id_flor' => 2,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Rojo',
            'imagen' => 'https://i.imgur.com/OqWvbCA.jpeg', 
            'id_flor' => 3, 
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Morado',
            'imagen' => 'https://i.imgur.com/hd1XLqW.png', 
            'id_flor' => 3,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/LKn08vC.jpeg', 
            'id_flor' => 3,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Rojo',
            'imagen' => 'https://i.imgur.com/t56qjJS.png', 
            'id_flor' => 4, 
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/Glsbngc.jpeg', 
            'id_flor' => 4,
        ]);

        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/SjL2Sq2.png', 
            'id_flor' => 4,
        ]);
    }
}
