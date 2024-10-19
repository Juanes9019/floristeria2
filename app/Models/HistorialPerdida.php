<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPerdida extends Model
{
    use HasFactory;

    protected $table = 'historial_perdidas';

    protected $fillable = ['insumo_id', 'cantidad_perdida', 'fecha_perdida'];

    public function insumo()
    {
        return $this->belongsTo(Insumo::class);
    }
}

