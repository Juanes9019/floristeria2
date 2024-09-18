<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pqrs extends Model
{
    use HasFactory;

    protected $table = 'pqrs';

    protected $fillable = [
        'user_id',
        'estado',
        'fecha_envio',
        'tipo',
        'motivo',
        'descripcion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
