<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria_insumo extends Model
{
    use HasFactory;

    protected $fillable=[
        'nombre',
        'estado'
    ];
    
    public function insumos()
    {
        return $this->hasMany(Insumo::class, 'id_categoria_insumo');
    }

    public function scopeSearch($query, $value)
    {
        $query->where('nombre', 'like', "%{$value}%");
    }

}
