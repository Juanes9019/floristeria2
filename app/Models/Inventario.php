<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario'; 

    public function producto()
    {
        return $this->belongsTo(producto::class, 'id_producto');
    }
}
