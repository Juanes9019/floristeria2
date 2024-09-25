<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'id_categoria',
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'foto',
        'estado'
    ];

    public function getDescripcionLimitadaAttribute()
    {
        return Str::limit($this->descripcion, 25); 
    }

    public function categoria_producto()
    {
        return $this->belongsTo(Categoria_Producto::class, 'id_categoria_producto');
    }
}
