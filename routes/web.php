<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\Sub_categoriaController;
use App\Http\Controllers\Admin\productosController;
use App\Http\Controllers\Admin\pedidoController;
use App\Http\Controllers\Admin\detalleController;
use App\Http\Controllers\Admin\inventarioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\carritoController;



// $role= Role::create(['name'=>'admin']);
// $role= Role::create(['name'=>'cliente']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user/perfil', [HomeController::class, 'perfilUser'])->name('perfilUser');
Route::get('/admin/perfil', [HomeController::class, 'perfilAdmin'])->name('perfilAdmin');

Route::get('/arreglo/{id}', [HomeController::class, 'show'])->name('view_arreglo.arreglo_view');

//rutas para el carrito
Route::get('home/carrito', [carritoController::class, 'index'])->name('home/carrito');
Route::get('carrito/add', [carritoController::class, 'add'])->name('add');
Route::get('carrito/clear', [carritoController::class, 'clear'])->name('clear');
Route::post('carrito/remove', [carritoController::class, 'removeItem'])->name('removeItem');

Route::get('carrito/incrementar', [carritoController::class, 'incrementar'])->name('incrementarCantidad');
Route::get('carrito/decrementar', [carritoController::class, 'decrementar'])->name('decrementarCantidad');

Route::get('/confirmarCarrito', [CarritoController::class, 'confirmarCarrito'])->name('confirmarCarrito');


Route::get('/pdf', [CarritoController::class, 'pdf'])->name('pdf');

//midleware para controlar el acceso solo a los administradores
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    //ruta para dashboard
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    //rutas para los usuarios
    Route::get('admin/users', [UserController::class, 'index'])->name('Admin.users');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('Admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('Admin.users.store');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('Admin.users.edit');
    Route::put('admin/users/{id}', [UserController::class, 'update'])->name('Admin.users.update');
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('Admin.users.destroy');


    //rutas para los proveedor
    Route::get('admin/proveedor', [ProveedorController::class, 'index'])->name('Admin.proveedor');
    Route::get('admin/proveedor/create', [ProveedorController::class, 'create'])->name('Admin.proveedor.create');
    Route::post('admin/proveedor', [ProveedorController::class, 'store'])->name('Admin.proveedor.store');
    Route::get('admin/proveedor/{id}/edit', [ProveedorController::class, 'edit'])->name('Admin.proveedor.edit');
    Route::put('admin/proveedor/{id}', [ProveedorController::class, 'update'])->name('Admin.proveedor.update');
    Route::delete('admin/proveedor/{id}', [ProveedorController::class, 'destroy'])->name('Admin.proveedor.destroy');

    //rutas para la categoria
    Route::get('admin/categoria', [CategoriaController::class, 'index'])->name('Admin.categoria');
    Route::get('admin/categoria/create', [CategoriaController::class, 'create'])->name('Admin.categoria.create');
    Route::post('admin/categoria', [CategoriaController::class, 'store'])->name('Admin.categoria.store');
    Route::get('admin/categoria/{id}/edit', [CategoriaController::class, 'edit'])->name('Admin.categoria.edit');
    Route::put('admin/categoria/{id}', [CategoriaController::class, 'update'])->name('Admin.categoria.update');
    Route::delete('admin/categoria/{id}', [CategoriaController::class, 'destroy'])->name('Admin.categoria.destroy');

    //rutas para la sub_categoria
    Route::get('admin/sub_categoria', [Sub_categoriaController::class, 'index'])->name('Admin.sub_categoria');
    Route::get('admin/sub_categoria/create', [Sub_categoriaController::class, 'create'])->name('Admin.sub_categoria.create');
    Route::post('admin/sub_categoria', [Sub_categoriaController::class, 'store'])->name('Admin.sub_categoria.store');
    Route::get('admin/sub_categoria/{id}/edit', [Sub_categoriaController::class, 'edit'])->name('Admin.sub_categoria.edit');
    Route::put('admin/sub_categoria/{id}', [Sub_categoriaController::class, 'update'])->name('Admin.sub_categoria.update');
    Route::delete('admin/sub_categoria/{id}', [Sub_categoriaController::class, 'destroy'])->name('Admin.sub_categoria.destroy');

    //rutas para los productos
    Route::get('admin/productos', [productosController::class, 'index'])->name('Admin.productos');
    Route::get('admin/productos/create', [productosController::class, 'create'])->name('Admin.productos.create');
    Route::post('admin/productos', [productosController::class, 'store'])->name('Admin.productos.store');
    Route::get('admin/productos/{id}/edit', [productosController::class, 'edit'])->name('Admin.productos.edit');
    Route::put('admin/productos/{id}', [productosController::class, 'update'])->name('Admin.productos.update');
    Route::delete('admin/productos/{id}', [productosController::class, 'destroy'])->name('Admin.productos.destroy');

    //rutas para los inventario
    Route::get('admin/inventario', [inventarioController::class, 'index'])->name('Admin.inventario');
    Route::get('admin/inventario/create', [inventarioController::class, 'create'])->name('Admin.inventario.create');
    Route::post('admin/inventario', [inventarioController::class, 'store'])->name('Admin.inventario.store');
    Route::get('admin/inventario/{id}/edit', [inventarioController::class, 'edit'])->name('Admin.inventario.edit');
    Route::put('admin/inventario/{id}', [inventarioController::class, 'update'])->name('Admin.inventario.update');
    Route::delete('admin/inventario/{id}', [inventarioController::class, 'destroy'])->name('Admin.inventario.destroy');

// Rutas para el pedido
Route::get('admin/pedido', [PedidoController::class, 'index'])->name('pedidos');
Route::post('admin/pedido/{id}/cambiar-estado', [PedidoController::class, 'cambiar_estado'])->name('cambiar_estado');
Route::get('admin/pedido/{id}/detalles', [PedidoController::class, 'mostrar'])->name('pedidos.detalles');

// Rutas para el detalle
Route::get('admin/detalle', [DetalleController::class, 'index'])->name('detalles');



});



Route::get('api/pedido', [pedidoController::class, 'getPedidos'])->name('api.pedido');

Route::post('api/pedido/aceptar/{id}', [PedidoController::class, 'aceptarPedido'])->name('api.pedido.aceptar');
Route::delete('api/pedido/rechazar/{id}', [PedidoController::class, 'rechazarPedido'])->name('api.pedido.rechazar');



Route::get('api/detalle', [DetalleController::class, 'getDetalles'])->name('api.detalles');

