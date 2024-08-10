<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    protected $fillable = [
        'id_categoria_insumo',
        'cantidad_insumo',
        'precio',
        'perdida_insumo',
    ];

}
