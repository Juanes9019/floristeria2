<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_proveedor',
        'costo_total',
        'estado',
    ];

    protected $dates = ['created_at', 'updated_at']; // Asegúrate de que Laravel maneje estos campos como fechas

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompraV2::class, 'compra_id');
    }

    public function scopeSearch($query, $value)
    {
        $query->whereHas('proveedor', function ($q) use ($value) {
            $q->where('nombre', 'like', "%{$value}%");
        });
    }
}
