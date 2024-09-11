<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roleIds)
    {
        // Verificar si el usuario está autenticado
        if (auth()->check()) {
            // Verificar si el rol del usuario está en la lista de roles permitidos
            if (in_array(auth()->user()->id_rol, $roleIds)) {
                return $next($request);
            }
        }
    
        // Si el usuario no tiene el rol adecuado, mostrar la página de acceso denegado
        return response()->view('errors.accesoDenegado');
    }
    
    
}
