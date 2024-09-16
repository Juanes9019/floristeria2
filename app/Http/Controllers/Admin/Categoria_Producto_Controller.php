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
        $categorias_productos = Categoria_Producto::all();
        $i = 0;
        return view('Admin.categoria_producto.index', compact('categorias_productos', 'i'));
    }

    public function create()
    {
        $categoria_producto = new Categoria_Producto();
        return view('Admin.categoria_producto.create', compact('categoria_producto'));
        }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        
        $categoria_producto = new Categoria_Producto;

        $categoria_producto->nombre = $request->nombre;
        if ($request->has('estado')) {
             $categoria_producto->estado = 1;
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
                return redirect()->route("Admin.categorias_productos")->with('error', 'No se puede eliminar la categoría porque está asociada a uno o más productos.');
            }
        } else {
            return redirect()->route("Admin.categorias_productos")->with('error', 'No se pudo encontrar la categoría');
        }
    }
    public function change_Status($id)
    {
        $categoria_producto = Categoria_Producto::find($id);
        if ($categoria_producto->estado == 1) {
            $categoria_producto->estado = 0;
        } else {
            $categoria_producto->estado = 1;
        }

        $categoria_producto->save();
        return redirect()->back();
    }
}
