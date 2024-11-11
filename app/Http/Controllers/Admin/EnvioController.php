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

    public function motivo_rechazo(Request $request)
    {
        // Validar que ambos campos sean requeridos
        $request->validate([
            'motivo' => 'required|string', 
            'descripcion' => 'required|string', 
            'id_pedido' => 'required|exists:pedidos,id', 
        ]);
    
        $pedido = Pedido::find($request->id_pedido);
        
        $pedido->datos_rechazo = json_encode([
            'motivo' => $request->motivo,
            'descripcion' => $request->descripcion,
        ]);
        
        $pedido->estado = 'no recibido';
        
        $pedido->save();
        
        return redirect()->route('envio.index')->with('success', 'Motivo recibido correctamente');
    }
}
