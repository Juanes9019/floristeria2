<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flor extends Model
{
    use HasFactory;

    protected $table = 'flores';

    protected $fillable = [
        'tipo_flor_id', 
        'nombre','precio'
    ];

    public function tipoFlor()
    {
        return $this->belongsTo(TipoFlor::class, 'tipo_flor_id');
    }
}
