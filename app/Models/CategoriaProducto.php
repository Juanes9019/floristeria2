<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    use HasFactory;
    protected $table = 'categorias_productos';
    protected $primaryKey  = 'id_categoria_producto';

    public $timestamps= false;
    protected $fillable=[
        'nombre',
        'estado'
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('nombre', 'like', "%{$value}%");
                     
    }
}
