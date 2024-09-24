<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;

    protected $table = 'insumos';

    protected $fillable = [
        'id_categoria_insumo',
        'nombre',
        'cantidad_insumo',
        'costo_unitario',
        'perdida_insumo',
        'costo_perdida',
        'estado'
    ];

    public function categoria_insumo(){
        return $this->belongsTo(Categoria_insumo::class, 'id_categoria_insumo');
    }

}