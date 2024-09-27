<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flor extends Model
{
    use HasFactory;

    protected $table = 'flores';

    protected $fillable = [
        'nombre','precio'
    ];


    public function colores()
    {
        return $this->hasMany(Color::class, 'id_flor'); 
    }
}
