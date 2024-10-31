<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoriaProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si el permiso 'categorias_productos' existe
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Categoria de productos')
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
        return view('Admin.categoria_producto.index');
    }

    public function create()
    {
        $user = auth()->user();

        // Verificar si el permiso 'categorias_productos' existe
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Categoria de productos')
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
        $categoria_producto = new CategoriaProducto();
        return view('Admin.categoria_producto.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|min:3|max:15|unique:categorias_productos',
            ],
            [
                'nombre.required' => 'El campo :attribute es requerido',
                'nombre.min' => 'El campo :attribute debe tener al menos :min caracteres',
                'nombre.max' => 'El campo :attribute debe ser menor que :max caracteres',
                'unique' => 'El :attribute ya existe.',
            ]
        );


        $categoria_producto = new CategoriaProducto();

        $categoria_producto->nombre = $request->nombre;
        if ($request->has('estado')) {
            $categoria_producto->estado = 0;
        }

        $categoria_producto->save();
        return redirect()->route('Admin.categorias_productos')
            ->with('success', 'Categoria de productos creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_categoria_producto)
    {
        $user = auth()->user();

    // Verificar si el permiso 'categorias_productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Categoria de productos')
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
        $categoria_producto = CategoriaProducto::findOrFail($id_categoria_producto);
        return view('Admin.categoria_producto.edit', ['categoria_producto' => $categoria_producto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_categoria_producto)
    {
        // Encuentra la categoria por su ID
        $categoria_producto = CategoriaProducto::find($id_categoria_producto);

        // Validaciones y lógica de actualización
        $request->validate([
            'nombre' => 'required|min:5',
        ]);

        // Actualiza los campos de la categoria utilizando el método save
        $categoria_producto->nombre = $request->input('nombre');
        if ($request->has('estado')) {
            $categoria_producto->estado = $request->estado;
        }
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
        $categoria_producto = CategoriaProducto::find($id_categoria_producto);

        // Verifica si la categoría está activa
        if ($categoria_producto->estado == 1) {
            return redirect()->route('Admin.categorias_productos')
                ->with('error', 'No se puede eliminar una Categoria Activa');
        }

        try {
            $categoria_producto->delete();
            return redirect()->route('Admin.categorias_productos')
                ->with('success', 'Categoría Eliminada con éxito');
        } catch (\Illuminate\Database\QueryException $e) {
            // Verifica si es un error de integridad referencial
            if ($e->getCode() == 23000) {
                return redirect()->route('Admin.categorias_productos')
                    ->with('error', 'No se puede eliminar la categoría porque está asociada a un producto.');
            }
            // Maneja otros posibles errores
            return redirect()->route('Admin.categorias_productos')
                ->with('error', 'Error al intentar eliminar la categoría.');
        }
    }
}
