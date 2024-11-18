<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;


class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Producto::create([
            'nombre' => 'Arreglo floral 1',
            'precio' => 150000,
            'id_categoria_producto' => 2, 
            'descripcion' => 'Este hermoso arreglo floral cuenta con una mezcla de flores frescas y vibrantes. Perfecto para expresar tus sentimientos en cualquier ocasión.',
            'cantidad' => 10,
            'foto' => 'https://i.imgur.com/nwIes3v.jpg'
        ]);
    
        Producto::create([
            'nombre' => 'Arreglo floral 2',
            'precio' => 230000,
            'id_categoria_producto' => 1, 
            'descripcion' => 'Un elegante arreglo floral diseñado para destacar en cualquier espacio. Con una combinación de flores exóticas y colores vivos, este arreglo es ideal para regalar.',
            'cantidad' => 10,
            'foto' => 'https://i.imgur.com/LvFA5iQ.jpg'
        ]);
    
        Producto::create([
            'nombre' => 'Arreglo floral 3',
            'precio' => 230000,
            'id_categoria_producto' => 1, 
            'descripcion' => 'Este delicado arreglo floral destaca por su combinación de flores premium y su elegante presentación. Perfecto para ocasiones especiales y momentos inolvidables.',
            'cantidad' => 10,
            'foto' => 'https://i.imgur.com/gZLNSnr.jpg'
        ]);
    
        Producto::create([
            'nombre' => 'Arreglo floral 4',
            'precio' => 210000,
            'id_categoria_producto' => 1, 
            'descripcion' => 'Un encantador arreglo floral que transmite amor y alegría. Con una variedad de flores frescas y fragantes, este arreglo es un regalo ideal para cualquier persona especial en tu vida.',
            'cantidad' => 10,
            'foto' => 'https://i.imgur.com/GmAKzPB.jpg'
        ]);
    
        Producto::create([
            'nombre' => 'Arreglo floral 5',
            'precio' => 200000,
            'id_categoria_producto' => 1, 
            'descripcion' => 'Este exquisito arreglo floral es una obra maestra de la naturaleza. Con una selección cuidadosa de flores premium y un diseño elegante, este arreglo es una expresión perfecta de tu buen gusto y estilo.',
            'cantidad' => 10,
            'foto' => 'https://i.imgur.com/6XkfReK.jpg'
        ]);
    }
}
