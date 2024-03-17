<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;


class productosController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $i = 0; 
        return view('Admin.producto.index', compact('productos', 'i'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario, incluida la imagen
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'id_categoria' => 'required|exists:categorias,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas de validación según tus necesidades
        ]);

        // Procesar la imagen
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('productos', $fileName, 'public');

        // Crear un nuevo producto con la información proporcionada y la ruta de la imagen
        $producto = new Producto([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'id_categoria' => $request->id_categoria,
            'foto' => $filePath,
        ]);

        // Guardar el producto en la base de datos
        $producto->save();

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }
}
