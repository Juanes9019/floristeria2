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
            return $user->hasPermission('Dashboard'); // Método para verificar el permiso
        });

        Gate::define('view-users', function (User $user) {
            return $user->hasPermission('Usuarios');
        });

        Gate::define('view-roles', function (User $user) {
            return $user->hasPermission('Roles');
        });

        Gate::define('view-pqrs', function (User $user) {
            return $user->hasPermission('Pqrs');
        });

        Gate::define('view-providers', function (User $user) {
            return $user->hasPermission('Proveedores');
        });

        Gate::define('view-insumo-categories', function (User $user) {
            return $user->hasPermission('Categoria de insumos');
        });

        Gate::define('view-insumos', function (User $user) {
            return $user->hasPermission('Insumos');
        });

        Gate::define('view-purchases', function (User $user) {
            return $user->hasPermission('Compras');
        });

        Gate::define('view-product-categories', function (User $user) {
            return $user->hasPermission('Categoria de productos');
        });

        Gate::define('view-products', function (User $user) {
            return $user->hasPermission('Productos');
        });

        Gate::define('view-orders', function (User $user) {
            return $user->hasPermission('Pedidos');
        });

        Gate::define('view-sales-detail', function (User $user) {
            return $user->hasPermission('Venta');
        });

        Gate::define('view-envio', function (User $user) {
            return $user->hasPermission('Envio');
        });
    }
}
