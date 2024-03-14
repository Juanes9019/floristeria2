<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\Sub_categoriaController;
use App\Http\Controllers\HomeController;


// $role= Role::create(['name'=>'admin']);
// $role= Role::create(['name'=>'cliente']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



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
});

Route::get('/user/perfil', [HomeController::class, 'perfilUser'])->name('perfilUser');
Route::get('/admin/perfil', [HomeController::class, 'perfilAdmin'])->name('perfilAdmin');


Route::group(['prefix'=> 'cliente','middleware' => ['auth','role:cliente']], function(){

});