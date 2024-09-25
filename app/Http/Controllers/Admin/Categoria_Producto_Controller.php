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
        
        return view('Admin.categoria_producto.index');
    }

    public function create()
    {
        $categoria_producto = new Categoria_Producto();
        return view('Admin.categoria_producto.create', compact('categoria_producto'));
        }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|min:3|max:15|unique:categorias_productos',
        ],
        [
            'nombre.required' => 'El campo :attribute es requerido',
            'nombre.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'nombre.max' => 'El campo :attribute debe ser menor que :max caracteres',
            'unique' => 'El :attribute ya existe.',
        ]
    );

        
        $categoria_producto = new Categoria_Producto;

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
        $categoria_producto = Categoria_Producto::find($id_categoria_producto);

        if ($categoria_producto->estado == 1) {
            return redirect()->route('Admin.categorias_productos')
                ->with('error', 'No se puede eliminar una Categoria Activa');
        }
        $categoria_producto->delete();

        return redirect()->route('Admin.categorias_productos')
                ->with('success','Categoria Eliminada con éxito');
    }
    // public function change_Status($id)
    // {
    //     $categoria_producto = Categoria_Producto::find($id);
    //     if ($categoria_producto->estado == 1) {
    //         $categoria_producto->estado = 0;
    //     } else {
    //         $categoria_producto->estado = 1;
    //     }

    //     $categoria_producto->save();
    //     return redirect()->back();
    // }
}
