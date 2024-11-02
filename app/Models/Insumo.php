<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InsumoProducto;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    protected $fillable = [
        'id_categoria_insumo',
        'nombre',
        'color',
        'cantidad_insumo',
        'costo_unitario',
        'perdida_insumo',
        'costo_perdida',
        'imagen',
        'descripcion',
        'estado'
    ];

    public function categoria_insumo()
    {
        return $this->belongsTo(Categoria_insumo::class, 'id_categoria_insumo');
    }
    
    public function scopeSearch($query, $value)
    {
        $query->where('nombre', 'like', "%{$value}%")
              ->orWhere('id_categoria_insumo', 'like', "%{$value}%")
              ->orWhereHas('categoria_insumo', function ($q) use ($value) {
                  $q->where('nombre', 'like', "%{$value}%");
              });
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'insumos_producto', 'id_insumo', 'id_producto')
                    ->withPivot('cantidad_usada');
    }
    
}
