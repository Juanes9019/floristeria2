<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Detalle;
use Illuminate\Support\Facades\DB;



class EnvioController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si el permiso 'envio' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Envio')
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

        $pedidos = Pedido::where('estado', 'en camino')->with('detalles')->get();
        $detalles = Detalle::all();
        
        return view('Admin.envio.index', compact('pedidos', 'detalles'));
    }

    public function motivo_rechazo(Request $request)
    {
        $user = auth()->user();

        // Verificar si el permiso envio existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Envio')
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
