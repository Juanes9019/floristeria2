<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InsumoProducto extends Model
{
    protected $table = 'insumos_producto';

    protected $fillable = [
        'nombre',
        'id_insumo',
        'id_producto',
        'cantidad_usada',
    ];

    public function insumos()
    {
        return $this->belongsToMany(Insumo::class,'id_insumo');
    }
    public function productos()
    {
        return $this->belongsToMany(Producto::class,'id_producto');
    }
}
