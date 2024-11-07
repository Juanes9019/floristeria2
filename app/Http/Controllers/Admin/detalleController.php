<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Detalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class detalleController extends Controller
{
    public function index(){
        $user = auth()->user();

    // Verificar si el permiso 'detalle' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Venta')
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
        $detalles = Detalle::all();
        return view('Admin.detalle.index', compact('detalles'));
    }

    public function getDetalles()
    {
        $detalles = Detalle::all();
        return response()->json($detalles);
    }
}
