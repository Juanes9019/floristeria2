<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Permisos_rol; // Asegúrate de importar el modelo correcto

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $permissions
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        $user = Auth::user();

        // Verifica si el usuario está autenticado
        if (!$user) {
            return redirect('login'); // Redirigir si no está autenticado
        }

        // Obtener el rol del usuario (asumiendo que tienes un método para obtener el rol)
        $roleId = $user->id_rol; // O como hayas definido el acceso al rol

        // Obtener los permisos del usuario desde la tabla permisos_rol
        $userPermissions = Permisos_rol::where('id_rol', $roleId)
                                      ->pluck('id_permiso')
                                      ->toArray();

        // Verificar si el usuario tiene alguno de los permisos requeridos
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return $next($request); // Permitir acceso si tiene algún permiso
            }
        }

        // Si no tiene permisos, puedes redirigir o abortar
        abort(403, 'Unauthorized action.');
    }
}
