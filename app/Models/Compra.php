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

    protected $dates = ['created_at', 'updated_at']; 

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompraV2::class, 'compra_id');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('id_proveedor', 'like', "%{$search}%")
                     ->orWhere('costo_total', 'like', "%{$search}%")
                     ->orWhere('estado', 'like', "%{$search}%")
                     ->orWhereHas('proveedor', function ($q) use ($search) {  
                        $q->where('nombre', 'like', "%{$search}%");
                     });
    }
    
}
