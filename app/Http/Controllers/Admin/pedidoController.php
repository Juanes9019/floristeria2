<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class pedidoController extends Controller
{
    public function index(){
        $pedidos = Pedido::all();
        $i = 0; 
        return view('Admin.pedido.index', compact('pedidos', 'i'));
    }

    public function pedidoget()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }
    


    public function cambiar_estado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
    
        // Verificamos el estado actual del pedido
        if ($pedido->estado === 'nuevo') {
            // Si está nuevo y se hace clic en "Aceptar Pedido"
            $pedido->estado = 'preparacion';
        } elseif ($pedido->estado === 'preparacion') {
            // Si está en preparacion y se hace clic en "Aceptar Pedido" de nuevo
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            // Si está en camino y se hace clic en "Aceptar Pedido" de nuevo
            $pedido->estado = 'entregado';
        }
    
        $pedido->save();
    
        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }
}
