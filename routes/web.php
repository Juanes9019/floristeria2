<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\Sub_categoriaController;
use App\Http\Controllers\Admin\productosController;
use App\Http\Controllers\Admin\pedidoController;
use App\Http\Controllers\Admin\detalleController;
use App\Http\Controllers\Admin\inventarioController;
use App\Http\Controllers\Admin\InsumoController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\carritoController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;



Route::get('/', [HomeController::class, 'vista_inicial'])->name('/');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/perfil/perfil/{section?}', [HomeController::class, 'perfilUser'])->name('perfilUser');
Route::POST('/perfil/perfil/update_informacion', [HomeController::class, 'update_informacion'])->name('update_informacion');

Route::get('/arreglo/{id}', [HomeController::class, 'show'])->name('view_arreglo.arreglo_view');
Route::get('/all_products', [HomeController::class, 'show_all'])->name('all_products');
Route::get('/productos.filtrar', [HomeController::class, 'productos.filtrar'])->name('productos.filtrar');

//rutas para el carrito
Route::get('home/carrito', [carritoController::class, 'index'])->name('home/carrito');
Route::get('carrito/add', [carritoController::class, 'add'])->name('add');
Route::get('carrito/clear', [carritoController::class, 'clear'])->name('clear');
Route::post('carrito/remove', [carritoController::class, 'removeItem'])->name('removeItem');

Route::get('/ciudades', [CiudadController::class, 'obtenerCiudades']);


Route::get('carrito/incrementar', [carritoController::class, 'incrementar'])->name('incrementarCantidad');
Route::get('carrito/decrementar', [carritoController::class, 'decrementar'])->name('decrementarCantidad');

Route::post('/confirmar-carrito', [CarritoController::class, 'confirmarCarrito'])->name('confirmarCarrito');

//midleware para controlar el acceso solo a los administradores
Route::middleware(['auth', 'user-access:1'])->group(function () {

    //ruta para dashboard
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    //rutas para los usuarios
    Route::get('admin/users', [UserController::class, 'index'])->name('Admin.users');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('Admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('Admin.users.store');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('Admin.users.edit');
    Route::put('admin/users/{id}', [UserController::class, 'update'])->name('Admin.users.update');
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('Admin.users.destroy');

    //rutas para los roles
    Route::get('admin/roles', [RolesController::class, 'index'])->name('Admin.roles');
    Route::get('admin/roles/create', [RolesController::class, 'create'])->name('Admin.roles.create');
    Route::post('admin/roles', [RolesController::class, 'store'])->name('Admin.roles.store');
    Route::get('admin/roles/{id}/edit', [RolesController::class, 'edit'])->name('Admin.roles.edit');
    Route::put('admin/roles/{id}', [RolesController::class, 'update'])->name('Admin.roles.update');
    Route::delete('admin/roles/{id}', [RolesController::class, 'destroy'])->name('Admin.roles.destroy');


    //rutas para los proveedor
    Route::get('admin/proveedores', [ProveedorController::class, 'index'])->name('Admin.proveedores');
    Route::get('admin/proveedor/create', [ProveedorController::class, 'create'])->name('Admin.proveedor.create');
    Route::post('admin/proveedor', [ProveedorController::class, 'store'])->name('Admin.proveedor.store');
    Route::get('admin/proveedor/{id}/edit', [ProveedorController::class, 'edit'])->name('Admin.proveedor.edit');
    Route::put('admin/proveedor/{id}', [ProveedorController::class, 'update'])->name('Admin.proveedor.update');
    Route::delete('admin/proveedor/{id}', [ProveedorController::class, 'destroy'])->name('Admin.proveedor.destroy');
    Route::get('admin/proveedor/{id}/status', [ProveedorController::class, 'change_Status'])->name('Admin.proveedor.status');



    //rutas para los productos
    Route::get('admin/productos', [productosController::class, 'index'])->name('Admin.productos');
    Route::get('admin/producto/create', [productosController::class, 'create'])->name('Admin.producto.create');
    Route::post('admin/producto', [productosController::class, 'store'])->name('Admin.producto.store');
    Route::get('admin/producto/{id}/edit', [productosController::class, 'edit'])->name('Admin.producto.edit');
    Route::put('admin/producto/{id}', [productosController::class, 'update'])->name('Admin.producto.update');
    Route::delete('admin/producto/{id}', [productosController::class, 'destroy'])->name('Admin.producto.destroy');
    Route::get('admin/producto/{id}/status', [productosController::class, 'change_Status'])->name('Admin.producto.status');




    //rutas para la categoria
    Route::get('admin/categoria', [CategoriaController::class, 'index'])->name('Admin.categoria');
    Route::get('admin/categoria/create', [CategoriaController::class, 'create'])->name('Admin.categoria.create');
    Route::post('admin/categoria', [CategoriaController::class, 'store'])->name('Admin.categoria.store');
    Route::get('admin/categoria/{id}/edit', [CategoriaController::class, 'edit'])->name('Admin.categoria.edit');
    Route::put('admin/categoria/{id}', [CategoriaController::class, 'update'])->name('Admin.categoria.update');
    Route::delete('admin/categoria/{id}', [CategoriaController::class, 'destroy'])->name('Admin.categoria.destroy');
    Route::get('admin/categoria/{id}/status', [CategoriaController::class, 'change_Status'])->name('Admin.categoria.status');



    //rutas para la sub_categoria
    Route::get('admin/sub_categoria', [Sub_categoriaController::class, 'index'])->name('Admin.sub_categoria');
    Route::get('admin/sub_categoria/create', [Sub_categoriaController::class, 'create'])->name('Admin.sub_categoria.create');
    Route::post('admin/sub_categoria', [Sub_categoriaController::class, 'store'])->name('Admin.sub_categoria.store');
    Route::get('admin/sub_categoria/{id}/edit', [Sub_categoriaController::class, 'edit'])->name('Admin.sub_categoria.edit');
    Route::put('admin/sub_categoria/{id}', [Sub_categoriaController::class, 'update'])->name('Admin.sub_categoria.update');
    Route::delete('admin/sub_categoria/{id}', [Sub_categoriaController::class, 'destroy'])->name('Admin.sub_categoria.destroy');

    //rutas para los insumos
    Route::get('admin/insumo', [InsumoController::class, 'index'])->name('Admin.insumo');
    Route::get('admin/insumo/create', [InsumoController::class, 'create'])->name('Admin.insumo.create');
    Route::post('admin/insumo', [InsumoController::class, 'store'])->name('Admin.insumo.store');
    Route::get('admin/insumo/{id}/edit', [InsumoController::class, 'edit'])->name('Admin.insumo.edit');
    Route::put('admin/insumo/{id}', [InsumoController::class, 'update'])->name('Admin.insumo.update');
    Route::delete('admin/insumo/{id}', [InsumoController::class, 'destroy'])->name('Admin.insumo.destroy');

    
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
    Route::post('admin/pedido/{id}/rechazar', [PedidoController::class, 'rechazar'])->name('rechazar');
    Route::get('admin/pedido/{id}/detalles', [PedidoController::class, 'mostrar'])->name('pedidos.detalles');

    Route::get('/export-pdf', [ExportController::class, 'exportarPDF'])->name('export.pdf');
    Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('export.excel');
    
    // Rutas para el detalle
    Route::get('admin/detalle', [DetalleController::class, 'index'])->name('detalles');
});



//rutas para flutter pedido
Route::get('api/pedido', [pedidoController::class, 'getPedidos'])->name('api.pedido');
Route::post('api/pedido/aceptar/{id}', [PedidoController::class, 'aceptarPedido'])->name('api.pedido.aceptar');
Route::delete('api/pedido/rechazar/{id}', [PedidoController::class, 'rechazarPedido'])->name('api.pedido.rechazar');


//rutas para flutter detalle
Route::get('api/pedido/detalle/{id}', [PedidoController::class, 'detalle_flutter'])->name('api.pedido.detalle');
Route::get('api/detalle', [DetalleController::class, 'getDetalles'])->name('api.detalles');

//ruta para obtener el token
//se manda el token para que pueda funcinar el post, delete y put
Route::get('api/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
