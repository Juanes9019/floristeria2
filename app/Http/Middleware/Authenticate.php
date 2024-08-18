<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    protected function redirectTo(Request $request): ?string
    {
        // No redirigir si la ruta es la raíz
        if ($request->is('/')) {
            return null;
        }
    
        return $request->expectsJson() ? null : route('login');
    }
    
}
