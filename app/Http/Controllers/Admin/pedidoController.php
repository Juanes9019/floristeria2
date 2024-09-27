<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\EstadoPedido;
use App\Mail\PedidoCambiado;
use App\Models\Pedido;
use App\Models\Inventario;
use App\Models\Insumo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;


class PedidoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

    // Verificar si el permiso 'pedidos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'pedidos')
                ->first();
    
    // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
    if (!$permiso) {
        return response()->view('errors.accesoDenegado');
    }
                
    // Verificar si el usuario tiene el permiso asociado a su rol
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }
        $pedidos = Pedido::all();
        $i = 0; 
        return view('Admin.pedido.index', compact('pedidos', 'i'));
    }

    public function cambiar_estado(Request $request, $id)
{
    $pedido = Pedido::findOrFail($id);
    $action = $request->input('action');

    if ($action === 'reject') {
        $pedido->estado = 'rechazado';

    } elseif ($pedido->estado === 'nuevo') {
        $pedido->estado = 'preparacion';

        // Restar los insumos del inventario
        foreach ($pedido->detalles as $detalle) {
            // Si es un insumo personalizado
            if (is_null($detalle->id_producto)) {
                $items = json_decode($detalle->opciones, true)['items'];

                foreach ($items as $item) {
                    // Aquí asumes que el nombre del insumo es único o se utiliza un ID
                    $insumo = Insumo::where('nombre', $item['name'])->where('color', $item['color'])->first();
                    
                    if ($insumo) {
                        $insumo->cantidad_insumo -= $item['qty'];
                        $insumo->save();
                    }
                }
            } else {
                // Producto estándar
                $inventario = Inventario::where('id_producto', $detalle->id_producto)->first();
                if ($inventario) {
                    $inventario->cantidad -= $detalle->cantidad;
                    $inventario->save();
                }
            }
        }
        
    } elseif ($pedido->estado === 'preparacion') {
        $pedido->estado = 'en camino';

    } elseif ($pedido->estado === 'en camino') {
        $pedido->estado = 'entregado';
    }

    $pedido->save();

    if ($pedido->user) {
        $pedido->user->notify(new EstadoPedido($pedido));
        Mail::to($pedido->user->email)->send(new PedidoCambiado($pedido));
    }

    return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
}

    

    public function rechazar(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'nuevo') {
            $pedido->estado = 'rechazado';
        }

        $pedido->save();

        return redirect()->back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    public function mostrar($id)
    {
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        $i = 0; 
        return view('Admin.pedido.mostrar', compact('pedido','i'));
    }

    //funcionalidad en flutter

    //controlador para ver pedido en flutter
    public function getPedidos()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    //controlador para aceptar pedido e flutter
    public function aceptarPedido($id)
    {
        //id para encontrar el pedido
        $pedido = Pedido::findOrFail($id);

        if ($pedido->estado === 'nuevo') {
            $pedido->estado = 'preparacion';
        } elseif ($pedido->estado === 'preparacion') {
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            $pedido->estado = 'entregado';
        }

        $pedido->save();

        return response()->json(['message' => 'Estado del pedido actualizado correctamente', 'pedido' => $pedido], 200);
    }

    //controlador para rechazar pedido en flutter
    public function rechazarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
    
        // Método para borrar
        $pedido->delete();
    
        return response()->json(['message' => 'Pedido rechazado y eliminado correctamente'], 200);
    }
    

    //controlador para ver el detalle en fluuter
    public function detalle_flutter($id)
    {
        //pedido para flutter
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        return response()->json($pedido);
    }
}

