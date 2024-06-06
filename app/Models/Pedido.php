<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'fechapedido',
        'procedencia',
        'estado',
        'user_id',
    ];

    public function detalles(){
        return $this->hasMany(Detalle::class, 'id_pedido');
    }
}
