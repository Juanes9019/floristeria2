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
    public function index()
    {
        $detalles = DetalleCompraV2::with('insumo.categoria')->get();
        $i = 0; 
        return view('Admin.detalle.index', compact('detalles', 'i'));
    }

    public function getDetalles()
{
    $detalles = DetalleCompraV2::with('insumo.categoria')->get();

    $detallesConNombres = $detalles->map(function ($detalle) {
        return [
            'id_insumo' => $detalle->id_insumo,
            'insumo' => $detalle->insumo->nombre, 
            'categoria' => $detalle->insumo->categoria->nombre, // Se obtiene desde la relación
            'color' => $detalle->insumo->color, 
            'cantidad' => $detalle->cantidad,
            'costo_unitario' => $detalle->costo_unitario,
            'subtotal' => $detalle->subtotal,
        ];
    });

    return response()->json(['detalles' => $detallesConNombres]);
}


}
