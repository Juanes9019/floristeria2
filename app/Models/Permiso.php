<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permisos'; // Nombre de tu tabla de permisos

    protected $fillable = ['nombre']; // Asegúrate de incluir 'nombre' o el campo que tiene el nombre del permiso

    // En el modelo Rol.php
public function permisos() {
    return $this->belongsToMany(Permiso::class, 'permisos_rol', 'id_rol', 'id_permiso');
}
public function roles()
{
    return $this->belongsToMany(Role::class, 'permisos_rol', 'id_permiso', 'id_rol');
}

}
