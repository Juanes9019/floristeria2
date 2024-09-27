<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permisos_rol', 'id_rol', 'id_permiso');
    }

}
