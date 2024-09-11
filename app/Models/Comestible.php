<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comestible extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'comestibles';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'tipo',
        'estado',
        'precio',
    ];
}
