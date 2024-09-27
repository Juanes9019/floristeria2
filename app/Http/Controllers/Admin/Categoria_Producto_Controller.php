<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Categoria_Producto_Controller extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Verificar si el permiso 'categorias_productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'categorias_productos')
                ->first();
    
    // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
    if (!$permiso) {
        return response()->view('errors.accesoDenegado');
    }
                
    // Verificar si el usuario tiene el permiso asociado a su rol
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }

    // Obtener las categorías de productos si el usuario tiene permiso
    $categorias_productos = Categoria_Producto::all();
    $i = 0;
    return view('Admin.categoria_producto.index', compact('categorias_productos', 'i'));
}


    public function create()
    {
        $user = auth()->user();

    // Verificar si el permiso 'categorias_productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'categorias_productos')
                ->first();
    
    // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
    if (!$permiso) {
        return response()->view('errors.accesoDenegado');
    }
                
    // Verificar si el usuario tiene el permiso asociado a su rol
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }

        return view('Admin.categoria_producto.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
        ]);

        try {
            $result = DB::table('categorias_productos')->insert([
                'nombre' => $data['nombre'],
            ]);

            Log::info('Resultado de la inserción: ' . ($result ? 'Éxito' : 'Fallo'));

            if ($result) {
                Log::info('Intentando redireccionar');
                return redirect()->route('Admin.categorias_productos');
            } else {
                dd('Error al insertar en la base de datos');
            }
        } catch (\Exception $e) {
            Log::error('Error al insertar en la base de datos: ' . $e->getMessage());

            dd('Error al insertar en la base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_categoria_producto)
    {
        $user = auth()->user();

    // Verificar si el permiso 'categorias_productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'categorias_productos')
                ->first();
    
    // Si no se encuentra el permiso, retornar un error o mostrar la vista de acceso denegado
    if (!$permiso) {
        return response()->view('errors.accesoDenegado');
    }
                
    // Verificar si el usuario tiene el permiso asociado a su rol
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }
        $categoria_producto = Categoria_Producto::findOrFail($id_categoria_producto);
        return view('Admin.categoria_producto.edit', ['categoria_producto' => $categoria_producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_categoria_producto)
    {
        // Encuentra la categoria por su ID
        $categoria_producto = Categoria_Producto::find($id_categoria_producto);

        // Validaciones y lógica de actualización
        $request->validate([
            'nombre' => 'required|min:5',
        ]);

        // Actualiza los campos de la categoria utilizando el método save
        $categoria_producto->nombre = $request->input('nombre');
        $categoria_producto->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.categorias_productos', ['id' => $categoria_producto->id_categoria_producto])
            ->with('success', 'categoria actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_categoria_producto)
    {
        $categoria_producto = Categoria_Producto::find($id_categoria_producto);

        if ($categoria_producto) {
            try {
                $categoria_producto->delete();
                return redirect()->route("Admin.categorias_productos")->with('success', 'Categoría eliminada exitosamente');
            } catch (\Illuminate\Database\QueryException $e) {
                // Si hay una violación de restricción de integridad referencial, captura la excepción
                return redirect()->route("Admin.categorias_productos")->with('error', 'No se puede eliminar la categoría porque está asociada a uno o más productos.');
            }
        } else {
            return redirect()->route("Admin.categorias_productos")->with('error', 'No se pudo encontrar la categoría');
        }
    }
}
