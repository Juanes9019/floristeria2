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
        'id_categoria_producto',
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
    
    public function scopeSearch($query, $value)
    {
        $query->where('nombre', 'like', "%{$value}%")
        ->orWhere('id_categoria_producto', 'like', "%{$value}%")
        ->orWhereHas('categoria_producto', function ($q) use ($value) {
            $q->where('nombre', 'like', "%{$value}%");
        });
    }
}
