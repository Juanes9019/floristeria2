<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_Producto extends Model
{
    use HasFactory;
    protected $table = 'categorias_productos';
    protected $primaryKey  = 'id_categoria_producto';

    public $timestamps= false;
    protected $fillable=[
        'nombre',
        'estado'
    ];
}
