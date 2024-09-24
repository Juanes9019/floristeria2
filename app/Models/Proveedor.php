<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'telefono',
        'correo',
        'ubicacion',
        'estado'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where('nombre', 'like', "%{$value}%")
                     ->orWhere('telefono', 'like', "%{$value}%")
                     ->orWhere('correo', 'like', "%{$value}%");
    }
}
