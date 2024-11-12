<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Permisos_rol;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{

    public function inicio()
    {
        if(auth()->check()) {
            $user = auth()->user();
    
            // Obtener los permisos asociados al rol del usuario
            $permisos_usuario = DB::table('permisos_rol')
                                ->where('id_rol', $user->id_rol)
                                ->pluck('id_permiso')
                                ->toArray();
    
            // Obtener los IDs de los permisos específicos
            $permiso_roles_id = DB::table('permisos')->where('nombre', 'roles')->value('id');
            $permiso_usuarios_id = DB::table('permisos')->where('nombre', 'usuarios')->value('id');
            $permiso_dashboard_id = DB::table('permisos')->where('nombre', 'dashboard')->value('id');
            $permiso_pedidos_id = DB::table('permisos')->where('nombre', 'pedidos')->value('id');
            $permiso_proveedores_id = DB::table('permisos')->where('nombre', 'proveedores')->value('id');
            $permiso_categorias_productos_id = DB::table('permisos')->where('nombre', 'categorias_productos')->value('id');
            $permiso_categoria_insumos_id = DB::table('permisos')->where('nombre', 'categoria_insumos')->value('id');
            $permiso_insumos_id = DB::table('permisos')->where('nombre', 'insumos')->value('id');
            $permiso_productos_id = DB::table('permisos')->where('nombre', 'productos')->value('id');
            $permiso_compras_id = DB::table('permisos')->where('nombre', 'compras')->value('id');
            $permiso_detalle_venta_id = DB::table('permisos')->where('nombre', 'detalle_venta')->value('id');
            $permiso_pedidos_id = DB::table('permisos')->where('nombre', 'pedidos')->value('id');
            $permiso_pqrs_id = DB::table('permisos')->where('nombre', 'pqrs')->value('id');
            $permiso_envio_id = DB::table('permisos')->where('nombre', 'envio')->value('id');
            
            // Depuración para ver los permisos que tiene el rol actual
            //dd($permisos_usuario);  // Esto mostrará en pantalla los permisos del usuario actual.
            if(auth()->check() && (in_array($permiso_roles_id, $permisos_usuario) || in_array($permiso_usuarios_id, $permisos_usuario) || in_array($permiso_dashboard_id, $permisos_usuario) || in_array($permiso_pedidos_id, $permisos_usuario) || in_array($permiso_proveedores_id, $permisos_usuario) || in_array($permiso_categorias_productos_id, $permisos_usuario) || in_array($permiso_categoria_insumos_id, $permisos_usuario) || in_array($permiso_insumos_id, $permisos_usuario) || in_array($permiso_productos_id, $permisos_usuario) || in_array($permiso_compras_id, $permisos_usuario) || in_array($permiso_detalle_venta_id, $permisos_usuario) || in_array($permiso_pedidos_id, $permisos_usuario) || in_array($permiso_pqrs_id, $permisos_usuario) || in_array($permiso_envio_id, $permisos_usuario))){
                return view('admin.inicio.inicio');
            }
            else{
                return response()->view('errors.accesoDenegado');
            }
        }
        
    }
}
