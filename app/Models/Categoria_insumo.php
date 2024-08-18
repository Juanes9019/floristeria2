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

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }
}
