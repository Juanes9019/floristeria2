<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos_rol extends Model
{
    use HasFactory;

    protected $table = 'permisos_rol';

    protected $fillable = [
        'id_rol',
        'id_permiso',
    ];

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'id_rol');
    }

// En el modelo Rol.php
public function permisos() {
    return $this->belongsToMany(Permiso::class, 'permisos_rol', 'id_rol', 'id_permiso');
}


}

