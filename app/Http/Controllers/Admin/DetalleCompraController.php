<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DetalleCompraV2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DetalleCompraController extends Controller
{
    public function index(){
        $detalles = DetalleCompraV2::all();
        $i = 0; 
        return view('Admin.detalle.index', compact('detalles', 'i'));
    }

    public function getDetalles()
{
    $detalles = DetalleCompraV2::with(['categoria_insumo', 'insumo'])->get();

    $detallesConNombres = $detalles->map(function ($detalle) {
        return [
            'id_categoria_insumo' => $detalle->id_categoria_insumo,
            'categoria' => $detalle->categoria_insumo->nombre,
            'id_insumo' => $detalle->id_insumo,
            'insumo' => $detalle->insumo->nombre, 
            'color' => $detalle->insumo->color, 
            'cantidad' => $detalle->cantidad,
            'costo_unitario' => $detalle->costo_unitario,
            'subtotal' => $detalle->subtotal,
        ];
    });

    return response()->json(['detalles' => $detallesConNombres]);
}

}
