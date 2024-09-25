<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_Producto;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;
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
        $categorias_productos = Categoria_Producto::where('estado', 1)->get();
        return view('Admin.producto.create', compact('producto', 'categorias_productos'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'id_categoria_producto' => 'required',
            'nombre' => 'required|string',
            'descripcion' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',

        ]);

        // Procesar la imagen
        $file = $request->file('foto');
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID b00a4e0e1ff8717',
        ])->post('https://api.imgur.com/3/image', [
            'image' => base64_encode(file_get_contents($file)),
        ]);

        $producto = new Producto;

        $producto->id_categoria_producto = $request->id_categoria_producto;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->cantidad = $request->cantidad;
        $producto->precio = $request->precio;

        if ($response->successful()) {
            $foto = $response->json()['data']['link'];
            $producto->foto = $foto;
        } else {
            $producto->foto = "storage\app\public\productos\arreglo_1.jpg";
        }

        if ($request->has('estado')) {
            $producto->estado = 0;
        }

        $producto->save();
        return redirect()->route('Admin.productos')
            ->with('success', 'insumo creado con éxito.');
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        $categorias = Categoria_Producto::where('estado', 1)->get();
        return view('Admin.producto.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $producto = Producto::find($id);


        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto',
            'nombre' => 'required|string|unique:productos',
            'descripcion' => 'required|string',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'id_categoria_producto.required' => 'El campo categoría del producto es requerido.',
            'id_categoria_producto.exists' => 'La categoría seleccionada no es válida.',
            
            'nombre.required' => 'El nombre del producto es requerido.',
            'nombre.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombre.unique' => 'El nombre del producto ya existe.',
        
            'descripcion.required' => 'La descripción del producto es requerida.',
            
            'cantidad.required' => 'La cantidad del producto es requerida.',
            'cantidad.integer' => 'La cantidad del producto debe ser un número entero.',
            'cantidad.min' => 'La cantidad no puede ser negativa. .',
        
            'precio.required' => 'El precio del producto es requerido.',
            'precio.numeric' => 'El precio debe ser un valor numérico.',
            'precio.min' => 'El precio no puede ser negativo.',
        
            'foto.required' => 'La imagen del producto es requerida.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser de tipo jpeg, png o jpg.',
            'foto.max' => 'La imagen no debe superar los 2MB.',
        ]);

        // Asignación de los campos del usuario desde el formulario
        $producto->id_categoria_producto = $request->input('id_categoria_producto');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->cantidad = $request->input('cantidad');
        $producto->precio = $request->input('precio');
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID b00a4e0e1ff8717',
            ])->post('https://api.imgur.com/3/image', [
                'image' => base64_encode(file_get_contents($file)),
            ]);

            if ($response->successful()) {
                $foto = $response->json()['data']['link'];
                $producto->foto = $foto;
            }
        }


        if ($request->has('estado')) {
            $producto->estado = $request->estado;
        }


        $producto->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.productos', ['id' => $producto->id])
            ->with('success', 'producto actualizado exitosamente');
    }

    public function destroy($id)
    {

        $producto = Producto::find($id);
        if ($producto->estado == 1) {
            return redirect()->route('Admin.productos')
                ->with('error', 'No se puede eliminar un Producto Activo');
        }
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
