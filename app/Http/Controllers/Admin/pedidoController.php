<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\EstadoPedido;
use App\Exports\PedidoExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;
use App\Mail\PedidoCambiado;
use App\Models\Pedido;
use App\Models\Inventario;
use App\Models\Producto;
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

        $permiso = DB::table('permisos')
            ->where('nombre', 'Pedidos')
            ->first();

        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }

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

            foreach ($pedido->detalles as $detalle) {
                if (is_null($detalle->id_producto)) {
                    $items = json_decode($detalle->opciones, true)['items'];

                    foreach ($items as $item) {
                        $insumo = Insumo::where('nombre', $item['name'])->where('color', $item['color'])->first();

                        if ($insumo) {
                            $insumo->cantidad_insumo -= $item['qty'];
                            $insumo->save();
                        }
                    }
                } else {
                    $producto = Producto::find($detalle->id_producto);
                    if ($producto) {
                        // Descontar los insumos que pertenecen al producto
                        foreach ($producto->insumos as $insumo) {
                            $cantidadUsada = $insumo->pivot->cantidad_usada; // cantidad usada en el producto
                            $insumo->cantidad_insumo -= $cantidadUsada * $detalle->cantidad; // descontar por la cantidad del pedido
                            $insumo->save();
                        }
                    }
                }
            }
        } elseif ($pedido->estado === 'preparacion') {
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            $pedido->estado = 'entregado';
        } elseif ($pedido->estado === 'no recibido') {
            $pedido->estado = 'en camino';
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
        $user = auth()->user();

        $permiso = DB::table('permisos')
            ->where('nombre', 'Pedidos')
            ->first();

        if (!$permiso) {
            return response()->view('errors.accesoDenegado');
        }

        $tienePermiso = DB::table('permisos_rol')
            ->where('id_rol', $user->id_rol)
            ->where('id_permiso', $permiso->id)
            ->exists();

        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        $i = 0;
        return view('Admin.pedido.mostrar', compact('pedido', 'i'));
    }

    //funcionalidad en flutter

    //controlador para ver pedido en flutter
    public function getPedidos()
    {
        $pedidos = Pedido::all();
        return response()->json($pedidos);
    }

    public function pedidoCli(Request $request, $id)
    {
        // Filtrar los pedidos por el ID del cliente proporcionado en la URL
        $pedidos = Pedido::where('id', $id)->get();

        return response()->json($pedidos, 200);
    }



    //controlador para aceptar pedido e flutter
    public function aceptarPedido(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'reject') {
            $pedido->estado = 'rechazado';
        } elseif ($pedido->estado === 'nuevo') {
            $pedido->estado = 'preparacion';

            foreach ($pedido->detalles as $detalle) {
                if (is_null($detalle->id_producto)) {
                    $items = json_decode($detalle->opciones, true)['items'];

                    foreach ($items as $item) {
                        $insumo = Insumo::where('nombre', $item['name'])->where('color', $item['color'])->first();

                        if ($insumo) {
                            $insumo->cantidad_insumo -= $item['qty'];
                            $insumo->save();
                        }
                    }
                } else {
                    $producto = Producto::find($detalle->id_producto);
                    if ($producto) {
                        // Descontar los insumos que pertenecen al producto
                        foreach ($producto->insumos as $insumo) {
                            $cantidadUsada = $insumo->pivot->cantidad_usada; // cantidad usada en el producto
                            $insumo->cantidad_insumo -= $cantidadUsada * $detalle->cantidad; // descontar por la cantidad del pedido
                            $insumo->save();
                        }
                    }
                }
            }
        } elseif ($pedido->estado === 'preparacion') {
            $pedido->estado = 'en camino';
        } elseif ($pedido->estado === 'en camino') {
            $pedido->estado = 'entregado';
        } elseif ($pedido->estado === 'no recibido') {
            $pedido->estado = 'en camino';
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


    public function export($format)
    {
        $export = new PedidoExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.pedidos', [
                    'pedidos' => Pedido::all()
                ])->setPaper('a4', 'portait')
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('pedidos.pdf');
            case 'xlsx':
            default:
                return $export->download('pedidos.xlsx', Excel::XLSX);
        }
    }
}
