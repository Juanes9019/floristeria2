<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'detalles';

    protected $fillable = ['precio', 'cantidad', 'importe', 'id_producto', 'id_pedido', 'subtotal','impuesto','imagen'];

    protected $casts = [
        'importe' => 'decimal:2',
    ];

    public function pedido(){
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}

