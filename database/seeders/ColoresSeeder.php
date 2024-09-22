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
            'descripcion' => 'El clavel blanco simboliza pureza y amor incondicional. Ideal para momentos de paz y respeto.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Rosado',
            'imagen' => 'https://i.imgur.com/F3KjnwJ.jpeg', 
            'id_flor' => 1,
            'descripcion' => 'Los claveles rosados representan la gratitud y el cariño, comúnmente regalados a personas cercanas en señal de aprecio.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/ihurqZn.png', 
            'id_flor' => 1,
            'descripcion' => 'El clavel amarillo transmite alegría y amistad, perfecto para celebraciones y momentos de felicidad.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/NkIcRVK.png', 
            'id_flor' => 2,
            'descripcion' => 'El tulipán blanco expresa elegancia y respeto, a menudo utilizado en ocasiones solemnes o para transmitir paz.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Morado',
            'imagen' => 'https://i.imgur.com/wkTkKas.jpeg', 
            'id_flor' => 2,
            'descripcion' => 'Este tulipán morado es símbolo de lujo y admiración, una elección perfecta para destacar en eventos formales.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/lIpVzYT.png',
            'id_flor' => 2,
            'descripcion' => 'El tulipán amarillo es sinónimo de felicidad y luz, ideal para expresar alegría y entusiasmo.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Rojo',
            'imagen' => 'https://i.imgur.com/OqWvbCA.jpeg', 
            'id_flor' => 3, 
            'descripcion' => 'Las orquídeas rojas son una representación de pasión y fuerza, una flor llamativa y poderosa para ocasiones especiales.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Morado',
            'imagen' => 'https://i.imgur.com/hd1XLqW.png', 
            'id_flor' => 3,
            'descripcion' => 'Esta orquídea morada evoca misterio y sofisticación, perfecta para regalar a alguien único y especial.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/LKn08vC.jpeg', 
            'id_flor' => 3,
            'descripcion' => 'La orquídea blanca representa pureza y elegancia, ideal para ocasiones formales o para expresar sentimientos nobles.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Rojo',
            'imagen' => 'https://i.imgur.com/t56qjJS.png', 
            'id_flor' => 4, 
            'descripcion' => 'La rosa roja es el símbolo universal del amor y la pasión, utilizada tradicionalmente para expresar afecto profundo.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Blanco',
            'imagen' => 'https://i.imgur.com/Glsbngc.jpeg', 
            'id_flor' => 4,
            'descripcion' => 'Las rosas blancas representan pureza y nuevos comienzos, a menudo vistas en bodas y ceremonias importantes.'
        ]);
        
        DB::table('colores')->insert([
            'nombre' => 'Amarillo',
            'imagen' => 'https://i.imgur.com/SjL2Sq2.png', 
            'id_flor' => 4,
            'descripcion' => 'Las rosas amarillas simbolizan amistad y alegría, una elección vibrante para expresar aprecio entre amigos.'
        ]);        
    }
}
