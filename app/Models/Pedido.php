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
        'estado',
        'comprobante_url',
        'user_id',
    ];

    public function detalles(){
        return $this->hasMany(Detalle::class, 'id_pedido');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('user_id', 'like', "%{$search}%") 
                     ->orWhere('total', 'like', "%{$search}%")
                     ->orWhere('fechapedido', 'like', "%{$search}%")
                     ->orWhere('estado', 'like', "%{$search}%");
    }
    

}
