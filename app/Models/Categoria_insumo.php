<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_insumo extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_proveedor',
        'nombre',
        'estado'
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
    
    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'id_categoria_insumo');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('id_proveedor', 'like', "%{$value}%")
            ->orWhere('nombre', 'like', "%{$value}%")
            ->orWhereHas('proveedor', function ($q) use ($value) {
                $q->where('nombre', 'like', "%{$value}%");
            });
    }

}
