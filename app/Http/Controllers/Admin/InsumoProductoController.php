<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Models\InsumoProducto;
use Illuminate\Support\Facades\DB;



class InsumoProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si el permiso 'productos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Productos')
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
        return view('Admin.insumo_producto.index');
    }
}
