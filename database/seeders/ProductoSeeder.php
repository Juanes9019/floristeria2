<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 1',
            'precio' => 150000,
            'id_categoria' => 1, 
            'descripcion' => 'Este hermoso arreglo floral cuenta con una mezcla de flores frescas y vibrantes. Perfecto para expresar tus sentimientos en cualquier ocasión.',
            'foto' => 'https://i.imgur.com/nwIes3v.jpg'
        ]);
        
        DB::table('productos')->insert([
            'nombre' => 'Arreglo  floral 2',
            'precio' => 230000,
            'id_categoria' => 1, 
            'descripcion' => 'Un elegante arreglo floral diseñado para destacar en cualquier espacio. Con una combinación de flores exóticas y colores vivos, este arreglo es ideal para regalar.',
            'foto' => 'https://i.imgur.com/LvFA5iQ.jpg'
        ]);
        
        DB::table('productos')->insert([
            'nombre' => 'Arreglo  floral 3',
            'precio' => 230000,
            'id_categoria' => 1, 
            'descripcion' => 'Este delicado arreglo floral destaca por su combinación de flores premium y su elegante presentación. Perfecto para ocasiones especiales y momentos inolvidables.',
            'foto' => 'https://i.imgur.com/gZLNSnr.jpg  '
        ]);
        
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 4',
            'precio' => 210000,
            'id_categoria' => 1, 
            'descripcion' => 'Un encantador arreglo floral que transmite amor y alegría. Con una variedad de flores frescas y fragantes, este arreglo es un regalo ideal para cualquier persona especial en tu vida.',
            'foto' => 'https://i.imgur.com/GmAKzPB.jpg'
        ]);
        
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 5',
            'precio' => 200000,
            'id_categoria' => 1, 
            'descripcion' => 'Este exquisito arreglo floral es una obra maestra de la naturaleza. Con una selección cuidadosa de flores premium y un diseño elegante, este arreglo es una expresión perfecta de tu buen gusto y estilo.',
            'foto' => 'https://i.imgur.com/6XkfReK.jpg'
        ]);
        
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 6',
            'precio' => 170000,
            'id_categoria' => 1, 
            'descripcion' => 'Arreglo floral vibrante con una mezcla de flores coloridas y frescas. Perfecto para alegrar cualquier evento o espacio.',
            'foto' => 'https://i.imgur.com/Q0wcRPz.jpeg'
        ]);
    
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 7',
            'precio' => 260000,
            'id_categoria' => 1, 
            'descripcion' => 'Arreglo elegante con flores exóticas y una presentación sofisticada. Ideal para ocasiones especiales y celebraciones.',
            'foto' => 'https://i.imgur.com/dzpIHAm.jpeg'
        ]);
    
        DB::table('productos')->insert([
            'nombre' => 'Arreglo floral 8',
            'precio' => 190000,
            'id_categoria' => 1, 
            'descripcion' => 'Un arreglo floral delicado y elegante con una mezcla de flores premium. Perfecto para regalar en momentos especiales.',
            'foto' => 'https://i.imgur.com/fPaZxSG.jpeg'
        ]);
    }
}
