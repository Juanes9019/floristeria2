<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accesorio extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'accesorios';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'estado',
        'precio',
    ];
}
