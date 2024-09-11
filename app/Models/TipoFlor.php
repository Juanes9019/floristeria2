<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFlor extends Model
{
    use HasFactory;

    protected $table = 'tipo_flores';

    protected $fillable = ['nombre'];

    public function flores()
    {
        return $this->hasMany(Flor::class, 'tipo_flor_id');
    }
}
