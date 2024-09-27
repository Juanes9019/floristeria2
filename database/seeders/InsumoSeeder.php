<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class InsumoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Clavel',
            'color' => 'Blanco',
            'cantidad_insumo' => 10,
            'costo_unitario' => 7000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/PLbh3p6.png', 
            'descripcion' => 'El clavel blanco simboliza pureza y amor incondicional. Ideal para momentos de paz y respeto.'
        ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Orquídeas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/F3KjnwJ.jpeg', 
            'descripcion' => 'Los claveles rosados representan la gratitud y el cariño, comúnmente regalados a personas cercanas en señal de aprecio.'
            ]);
            
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Gerberas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 700,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/wkTkKas.jpeg', 
            'descripcion' => 'Este tulipán morado es símbolo de lujo y admiración, una elección perfecta para destacar en eventos formales.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Tulipán',
            'color' => 'Amarillo',
            'cantidad_insumo' => 10,
            'costo_unitario' => 10500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/lIpVzYT.png',
            'descripcion' => 'El tulipán amarillo es sinónimo de felicidad y luz, ideal para expresar alegría y entusiasmo.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Orquídea',
            'color' => 'Rojo',
            'cantidad_insumo' => 0,
            'costo_unitario' => 19000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/OqWvbCA.jpeg', 
            'descripcion' => 'Las orquídeas rojas son una representación de pasión y fuerza, una flor llamativa y poderosa para ocasiones especiales.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Orquídea',
            'color' => 'Morado',
            'cantidad_insumo' => 0,
            'costo_unitario' => 21000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/hd1XLqW.png', 
            'descripcion' => 'Esta orquídea morada evoca misterio y sofisticación, perfecta para regalar a alguien único y especial.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Orquídea',
            'color' => 'Blanco',
            'cantidad_insumo' => 0,
            'costo_unitario' => 20000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/LKn08vC.jpeg', 
            'descripcion' => 'La orquídea blanca representa pureza y elegancia, ideal para ocasiones formales o para expresar sentimientos nobles.'
            ]);

        
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Rosa',
            'color' => 'Rojo',
            'cantidad_insumo' => 0,
            'costo_unitario' => 5500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/t56qjJS.png', 
            'descripcion' => 'La rosa roja es el símbolo universal del amor y la pasión, utilizada tradicionalmente para expresar afecto profundo.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Rosa',
            'color' => 'Blanco',
            'cantidad_insumo' => 0,
            'costo_unitario' => 5000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/Glsbngc.jpeg', 
            'descripcion' => 'Las rosas blancas representan pureza y nuevos comienzos, a menudo vistas en bodas y ceremonias importantes.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 1,
            'nombre' => 'Rosa',
            'color' => 'Amarillo',
            'cantidad_insumo' => 0,
            'costo_unitario' => 5000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            'imagen' => 'https://i.imgur.com/SjL2Sq2.png', 
            'descripcion' => 'Las rosas amarillas simbolizan amistad y alegría, una elección vibrante para expresar aprecio entre amigos.'
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 2,
            'nombre' => 'Osos',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Chocolatinas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Papas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 3,
            'nombre' => 'Gomitas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 1500,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 4,
            'nombre' => 'Yogurt',
            'cantidad_insumo' => 0,
            'costo_unitario' => 800,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 4,
            'nombre' => 'Cervezas',
            'cantidad_insumo' => 0,
            'costo_unitario' => 3000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Cuadrado',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Redondo',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);
            
        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Vasija',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);

        DB::table('insumos')->insert([
            'id_categoria_insumo' => 5,
            'nombre' => 'Vidrio',
            'cantidad_insumo' => 0,
            'costo_unitario' => 2000,
            'perdida_insumo' => 0,
            'costo_perdida' => 0,
            ]);
    }
}