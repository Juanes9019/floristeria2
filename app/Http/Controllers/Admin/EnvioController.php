<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Detalle;


class EnvioController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('estado', 'en camino')->with('detalles')->get();
        $detalles = Detalle::all();
        
        return view('Admin.envio.index', compact('pedidos', 'detalles'));
    }
}
