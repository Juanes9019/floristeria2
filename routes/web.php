<?php

use App\Exports\ProveedorExport;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\Categoria_Producto_Controller;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\Categoria_insumoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\pedidoController;
use App\Http\Controllers\Admin\detalleController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\DetalleCompraController;
use App\Http\Controllers\Admin\inventarioController;
use App\Http\Controllers\Admin\InsumoController;
use App\Http\Controllers\Admin\GenerarProductoController;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\InsumoProductoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\carritoController;
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCorreo;
use App\Models\CategoriaProducto;
use Illuminate\Support\Facades\Auth;
use App\Models\GenerarProducto;




Route::get('/', [HomeController::class, 'vista_inicial'])->name('/');


Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/perfil/perfil/{section?}', [HomeController::class, 'perfilUser'])->name('perfilUser');
Route::POST('/perfil/perfil/update_informacion', [HomeController::class, 'update_informacion'])->name('update_informacion');
Route::post('/pqrs', [HomeController::class, 'pqrs'])->name('pqrs');


Route::get('/arreglo/{id}', [HomeController::class, 'show'])->name('view_arreglo.arreglo_view');
Route::get('/all_products', [HomeController::class, 'show_all'])->name('all_products');
Route::get('/personalizados', [HomeController::class, 'personalizados'])->name('personalizados');
Route::get('/insumos/categoria/{categoria_id}', [HomeController::class, 'getInsumosPorCategoria']);



//rutas para las flores personalizadas
Route::post('/agregar-producto', [HomeController::class, 'agregar_producto'])->name('agregar_producto');
Route::patch('/actualizar-producto/{key}', [HomeController::class, 'actualizar_producto'])->name('actualizar_producto');
Route::delete('/eliminar-producto/{key}', [HomeController::class, 'eliminar_producto'])->name('eliminar_producto');


//personalizadas de accesorios
Route::post('/agregar-accesorio', [HomeController::class, 'agregarAccesorio'])->name('agregarAccesorio');
Route::patch('/actualizar-Accesorio/{key}', [HomeController::class, 'actualizarAccesorio'])->name('actualizarAccesorio');
Route::delete('/eliminar-Accesorio/{key}', [HomeController::class, 'eliminarAccesorio'])->name('eliminarAccesorio');


//personalizadas de comestibles 
Route::post('/agregar-comestible', [HomeController::class, 'agregarComestible'])->name('agregarComestible');
Route::patch('/actualizar-Comestible/{key}', [HomeController::class, 'actualizarComestible'])->name('actualizarComestible');
Route::delete('/eliminar-Comestible/{key}', [HomeController::class, 'eliminarComestible'])->name('eliminarComestible');



Route::get('/productos.filtrar', [HomeController::class, 'productos.filtrar'])->name('productos.filtrar');

//rutas para el carrito
Route::get('home/carrito', [carritoController::class, 'index'])->name('home/carrito');
Route::get('carrito/add', [carritoController::class, 'add'])->name('add');
Route::post('carrito/add_personalizado', [carritoController::class, 'add_personalizado'])->name('add_personalizado');
Route::get('carrito/clear', [carritoController::class, 'clear'])->name('clear');
Route::post('/carrito/eliminar', [CarritoController::class, 'removeItem'])->name('removeItem');


Route::get('carrito/incrementar', [carritoController::class, 'incrementar'])->name('incrementarCantidad');
Route::get('carrito/decrementar', [carritoController::class, 'decrementar'])->name('decrementarCantidad');

Route::post('/confirmar-carrito', [CarritoController::class, 'confirmarCarrito'])->name('confirmarCarrito');



//midleware para controlar el acceso solo a los administradores
//Route::middleware(['auth', 'user-access:1,3,4'])->group(function () {

    //ruta para dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //rutas para los usuarios
    Route::get('admin/users', [UserController::class, 'index'])->name('Admin.users');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('Admin.users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('Admin.users.store');
    Route::get('admin/users/{id}/edit', [UserController::class, 'edit'])->name('Admin.users.edit');
    Route::put('admin/users/{id}', [UserController::class, 'update'])->name('Admin.users.update');
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('Admin.users.destroy');

    Route::get('/usuarios/export/{format}', [UserController::class, 'export'])->name('Admin.users.export');

    Route::get('admin/users/pqrs', [UserController::class, 'index_pqrs'])->name('Admin.users.pqrs');
    Route::put('/pqrs/{id}/responder', [UserController::class, 'responderPqrs'])->name('pqrs.responder');



    //rutas para los roles
    Route::get('admin/roles', [RolesController::class, 'index'])->name('Admin.roles');
    Route::get('admin/roles/create', [RolesController::class, 'create'])->name('Admin.roles.create');
    Route::post('admin/roles', [RolesController::class, 'store'])->name('Admin.roles.store');
    Route::get('admin/roles/{id}/edit', [RolesController::class, 'edit'])->name('Admin.roles.edit');
    Route::put('admin/roles/{id}', [RolesController::class, 'update'])->name('Admin.roles.update');
    Route::delete('admin/roles/{id}', [RolesController::class, 'destroy'])->name('Admin.roles.destroy');


    Route::get('admin/permisos', [RolesController::class, 'permisos'])->name('Admin.permisos');
    Route::get('admin/permisos_rol', [RolesController::class, 'permisos_rol'])->name('Admin.permisos_rol');
    Route::post('admin/guardar_permiso', [RolesController::class, 'guardar_permiso'])->name('Admin.permisos.guardar_permiso');

    //rutas para permiso
    Route::put('/admin/permisos_rol/{id}', [RolesController::class, 'update_permiso_rol'])->name('permisos.update');



    //rutas para los proveedor
    Route::get('admin/proveedores', [ProveedorController::class, 'index'])->name('Admin.proveedores');
    Route::get('admin/proveedor/create', [ProveedorController::class, 'create'])->name('Admin.proveedor.create');
    Route::post('admin/proveedor', [ProveedorController::class, 'store'])->name('Admin.proveedor.store');
    Route::get('admin/proveedor/{id}/edit', [ProveedorController::class, 'edit'])->name('Admin.proveedor.edit');
    Route::put('admin/proveedor/{id}', [ProveedorController::class, 'update'])->name('Admin.proveedor.update');
    Route::delete('admin/proveedor/{id}', [ProveedorController::class, 'destroy'])->name('Admin.proveedor.destroy');
    Route::get('/proveedores/export/{format}', [ProveedorController::class, 'export'])->name('Admin.proveedores.export');

    // Route::get('admin/proveedor/{id}/status', [ProveedorController::class, 'change_Status'])->name('Admin.proveedor.status');



    //rutas para los productos
    Route::get('admin/productos', [ProductoController::class, 'index'])->name('Admin.productos');
    Route::get('producto/{id}', [ProductoController::class, 'show'])->name('Admin.producto.show');
    Route::get('admin/producto/create', [ProductoController::class, 'create'])->name('Admin.producto.create');
    Route::post('admin/producto', [ProductoController::class, 'store'])->name('Admin.producto.store');
    Route::get('admin/producto/{id}/edit', [ProductoController::class, 'edit'])->name('Admin.producto.edit');
    Route::put('admin/producto/{id}', [ProductoController::class, 'update'])->name('Admin.producto.update');
    Route::delete('admin/producto/{id}', [ProductoController::class, 'destroy'])->name('Admin.producto.destroy');
    Route::get('admin/producto/{id}/status', [ProductoController::class, 'change_Status'])->name('Admin.producto.status');
    Route::get('/export_producto_pdf', [ExportController::class, 'exportar_producto'])->name('export_producto.pdf');



    //rutas para la categoria
    Route::get('admin/categorias_productos', [CategoriaProducto::class, 'index'])->name('Admin.categorias_productos');
    Route::get('admin/categoria_producto/create', [CategoriaProducto::class, 'create'])->name('Admin.categoria_producto.create');
    Route::post('admin/categoria_producto', [CategoriaProducto::class, 'store'])->name('Admin.categoria_producto.store');
    Route::get('admin/categoria_producto/{id}/edit', [CategoriaProducto::class, 'edit'])->name('Admin.categoria_producto.edit');
    Route::put('admin/categoria_producto/{id}', [CategoriaProducto::class, 'update'])->name('Admin.categoria_producto.update');
    Route::delete('admin/categoria_producto/{id}', [CategoriaProducto::class, 'destroy'])->name('Admin.categoria_producto.destroy');
    
   
    Route::get('admin/insumo_producto', [InsumoProductoController::class, 'index'])->name('Admin.insumo_producto');
        
 

    //rutas para la categoria_insumo
    Route::get('admin/categoria_insumo', [Categoria_insumoController::class, 'index'])->name('Admin.categoria_insumo');
    Route::get('admin/categoria_insumo/create', [Categoria_insumoController::class, 'create'])->name('Admin.categoria_insumo.create');
    Route::post('admin/categoria_insumo', [Categoria_insumoController::class, 'store'])->name('Admin.categoria_insumo.store');
    Route::get('admin/categoria_insumo/{id}/edit', [Categoria_insumoController::class, 'edit'])->name('Admin.categoria_insumo.edit');
    Route::put('admin/categoria_insumo/{id}', [Categoria_insumoController::class, 'update'])->name('Admin.categoria_insumo.update');
    Route::delete('admin/categoria_insumo/{id}', [Categoria_insumoController::class, 'destroy'])->name('Admin.categoria_insumo.destroy');
    Route::get('admin/categoria_insumo/{id}/status', [Categoria_insumoController::class, 'change_Status'])->name('Admin.categoria_insumo.status');

    //rutas para los insumos
    Route::get('admin/insumo', [InsumoController::class, 'index'])->name('Admin.insumo');
    Route::get('admin/insumo/create', [InsumoController::class, 'create'])->name('Admin.insumo.create');
    Route::post('admin/insumo', [InsumoController::class, 'store'])->name('Admin.insumo.store');
    Route::get('admin/insumo/{id}/edit', [InsumoController::class, 'edit'])->name('Admin.insumo.edit');
    Route::put('admin/insumo/{id}', [InsumoController::class, 'update'])->name('Admin.insumo.update');
    Route::get('admin/insumo/perdida', [InsumoController::class, 'perdida'])->name('Admin.insumo.perdida');
    Route::post('admin/insumo/storePerdida', [InsumoController::class, 'storePerdida'])->name('admin.insumo.storePerdida');
    Route::get('admin/insumo/historial-perdidas', [InsumoController::class, 'historialPerdidas'])->name('Admin.insumo.historialPerdidas');
    // Route::delete('admin/insumo/{id}', [InsumoController::class, 'destroy'])->name('Admin.insumo.destroy');
    // Route::get('admin/insumo/{id}/incrementarInsumo', [InsumoController::class, 'incrementarInsumo'])->name('incrementarInsumo');
    // Route::get('admin/insumo/{id}/decrementarInsumo', [InsumoController::class, 'decrementarInsumo'])->name('decrementarInsumo');
    Route::get('admin/insumo/{id}/status', [InsumoController::class, 'change_Status'])->name('Admin.insumo.status');
    Route::get('/insumos/export/{format}', [InsumoController::class, 'export'])->name('Admin.insumos.export');


    // Rutas para el controlador CompraController
    Route::get('admin/compras', [CompraController::class, 'index'])->name('Admin.compra.index');
    Route::get('admin/compras/create', [CompraController::class, 'create'])->name('Admin.compra.create');
    Route::post('admin/compras', [CompraController::class, 'store'])->name('Admin.compra.store');
    Route::get('admin/compras/{id}', [CompraController::class, 'show'])->name('compra.detalles');
    route::get('/categorias/{idProveedor}', [CompraController::class, 'getCategorias'])->name('categorias');
    Route::get('/insumos/{idCategoria}', [CompraController::class, 'getInsumos'])->name('insumos');
    Route::delete('/admin/compras/{id}', [CompraController::class, 'destroy'])->name('Admin.compra.destroy');



    //Ruta para el detalle Compra
    Route::get('admin/DetalleCompra', [DetalleCompraController::class, 'index'])->name('detalles');

    //rutas para los productos
    Route::get('admin/productos', [ProductoController::class, 'index'])->name('Admin.productos');
    Route::get('admin/producto/create', [ProductoController::class, 'create'])->name('Admin.producto.create');
    Route::post('admin/producto', [ProductoController::class, 'store'])->name('Admin.producto.store');
    Route::get('admin/producto/{id}/edit', [ProductoController::class, 'edit'])->name('Admin.producto.edit');
    Route::put('admin/producto/{id}', [ProductoController::class, 'update'])->name('Admin.producto.update');
    Route::delete('admin/producto/{id}', [ProductoController::class, 'destroy'])->name('Admin.producto.destroy');
    Route::get('admin/producto/{id}/status', [ProductoController::class, 'change_Status'])->name('Admin.producto.status');
    Route::get('/export_producto_pdf', [ExportController::class, 'exportar_producto'])->name('export_producto.pdf');

    // Rutas para el pedido
    Route::get('admin/pedido', [PedidoController::class, 'index'])->name('pedidos');
    Route::post('admin/pedido/{id}/cambiar-estado', [PedidoController::class, 'cambiar_estado'])->name('cambiar_estado');
    Route::post('admin/pedido/{id}/rechazar', [PedidoController::class, 'rechazar'])->name('rechazar');
    Route::get('admin/pedido/{id}/detalles', [PedidoController::class, 'mostrar'])->name('pedidos.detalles');
    Route::get('/export-pdf', [ExportController::class, 'exportarPDF'])->name('export.pdf');
    Route::get('/export-excel', [ExportController::class, 'exportExcel'])->name('export.excel');


    // Rutas para el detalle
    Route::get('admin/detalle', [DetalleController::class, 'index'])->name('detalles');
    Route::get('/export_detalle_pdf', [ExportController::class, 'exportar_detalle'])->name('export_detalle.pdf');    

//});



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

Route::post('api/login', [UserController::class,'login']);