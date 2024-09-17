<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colores'; 
    protected $fillable = ['nombre', 'imagen', 'id_flor'];

    public function flor()
    {
        return $this->belongsTo(Flor::class, 'id_flor'); 
    }
}
