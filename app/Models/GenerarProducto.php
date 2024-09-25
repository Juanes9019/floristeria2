<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GenerarProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_insumo',
        'nombre',
    ];
    public function insumos():HasMany
    {
        return $this->hasMany(Insumo::class,'id_insumo','id');
    }
}
