<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompraV2 extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'detalle_compras_v2'; 

    protected $fillable = [
        'compra_id',
        'id_categoria_insumo',
        'id_insumo',
        'cantidad',
        'costo_unitario',
        'subtotal',
        'total',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo');
    }
}
