<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Asegúrate de importar Gate
use App\Models\User; // Asegúrate de importar el modelo User

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // Define tus políticas aquí
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Aquí defines tus permisos utilizando Gate
        Gate::define('view-dashboard', function (User $user) {
            return $user->hasPermission('dashboard'); // Método para verificar el permiso
        });

        Gate::define('view-users', function (User $user) {
            return $user->hasPermission('usuarios');
        });

        Gate::define('view-roles', function (User $user) {
            return $user->hasPermission('roles');
        });

        Gate::define('view-pqrs', function (User $user) {
            return $user->hasPermission('pqrs');
        });

        Gate::define('view-providers', function (User $user) {
            return $user->hasPermission('proveedores');
        });

        Gate::define('view-insumo-categories', function (User $user) {
            return $user->hasPermission('categoria_insumos');
        });

        Gate::define('view-insumos', function (User $user) {
            return $user->hasPermission('insumos');
        });

        Gate::define('view-purchases', function (User $user) {
            return $user->hasPermission('compras');
        });

        Gate::define('view-product-categories', function (User $user) {
            return $user->hasPermission('categorias_productos');
        });

        Gate::define('view-products', function (User $user) {
            return $user->hasPermission('productos');
        });

        Gate::define('view-orders', function (User $user) {
            return $user->hasPermission('pedidos');
        });

        Gate::define('view-sales-detail', function (User $user) {
            return $user->hasPermission('detalle_venta');
        });
    }
}
