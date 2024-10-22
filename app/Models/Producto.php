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
        return $this->belongsTo(CategoriaProducto::class, 'id_categoria_producto');
    }
    
    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'insumos_producto', 'id_producto', 'id_insumo')
                    ->withPivot('cantidad_usada'); 
    }
}