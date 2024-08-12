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
    public function handle(Request $request, Closure $next, $roleId)
    {
        if (auth()->check() && auth()->user()->id_rol == $roleId) {
            return $next($request);
        }
    
        return response()->view('errors.accesoDenegado');
    }
    
}
