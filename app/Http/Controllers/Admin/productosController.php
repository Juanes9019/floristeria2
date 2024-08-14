<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class productosController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $i = 0; 
        return view('Admin.producto.index', compact('productos', 'i'));
    }

    public function create()
    {
        $producto = new Producto(); 
        $categorias = DB::table('categorias')->get();
        return view('Admin.producto.create', compact('categorias','producto'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'id_categoria' => 'required',
            'nombre' => 'required|string',
            'descripcion' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'foto' => 'required', 
        ]);

        // Procesar la imagen
        // $file = $request->file('foto');
        // $fileName = time() . '_' . $file->getClientOriginalName();
        // $filePath = $file->storeAs('productos', $fileName, 'public');

        // Crear un nuevo producto con la información proporcionada y la ruta de la imagen
        $producto = new Producto;

        $producto->id_categoria = $request->id_categoria;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->cantidad = $request->cantidad;
        $producto->precio = $request->precio;
        $producto->foto = $request->foto;

        if ($request->has('estado')) {
             $producto->estado = 1;
        }

        $producto->save();
        return redirect()->route('Admin.productos')
        ->with('success', 'insumo creado con éxito.');
    }
    
    public function edit($id)    {
        $producto = Producto::find($id);
        $categorias = DB::table('categorias')->get();
        return view('Admin.producto.edit', compact('producto','categorias'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $producto = Producto::find($id);

        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria' => 'required|exists:categorias,id',
            'nombre' => 'required|string',
            'descripcion' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'foto' => 'required', 
        ]);

        // Asignación de los campos del usuario desde el formulario
        $producto->id_categoria = $request->input('id_categoria');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->cantidad = $request->input('cantidad');
        $producto->precio = $request->input('precio');
        $producto->foto = $request->input('foto');

        $producto->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.productos', ['id' => $producto->id])
        ->with('success', 'producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        $producto->delete();

        return redirect()->route('Admin.productos')
            ->with('success', 'producto eliminado con éxito');

    }

    public function change_Status($id)
    {
        $producto = Producto::find($id);
        if ($producto->estado == 1) {
            $producto->estado = 0;
        } else {
            $producto->estado = 1;
        }

        $producto->save();
        return redirect()->back();
    }
   
}
