<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GenerarProducto extends Model
{
    use HasFactory;

    protected $fillable = ['id_insumo', 'cantidad_utilizada'];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
    