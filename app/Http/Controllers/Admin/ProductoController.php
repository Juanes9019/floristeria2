<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_Producto;
use App\Models\CategoriaProducto;
use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ProductoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Verificar si el permiso 'productos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Productos')
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
        $productos = Producto::all();
        $i = 0;
        return view('Admin.producto.index', compact('productos', 'i'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        // Verificar si el permiso 'productos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Productos')
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
        // $categorias_productos = CategoriaProducto::where('estado', 1)->get();

        return view('Admin.producto.create');
    }


    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto',
            'nombre' => 'required|string|unique:productos,nombre',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'estado' => 'required|in:0,1',
        ]);

        // Procesar la imagen
        $file = $request->file('foto');
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID b00a4e0e1ff8717',
        ])->post('https://api.imgur.com/3/image', [
            'image' => base64_encode(file_get_contents($file)),
        ]);

        // Crear producto
        $producto = new Producto;
        $producto->id_categoria_producto = $request->id_categoria_producto;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio = $request->precio;
        $producto->estado = $request->estado;

        if ($response->successful()) {
            $producto->foto = $response->json()['data']['link'];
        } else {
            return redirect()->back()->withErrors('Error al subir la imagen a Imgur.');
        }

        $producto->save(); // Guardar el producto antes de asociar insumos

        // Manejar insumos seleccionados
        $insumosSeleccionados = session('insumos_agregados', []);
        if (!empty($insumosSeleccionados)) {
            foreach ($insumosSeleccionados as $insumo) {
                $insumoModel = Insumo::find($insumo['id']);
                if ($insumoModel) {
                    $insumoModel->cantidad_insumo -= $insumo['cantidad'];
                    $insumoModel->save();
                    $producto->insumos()->attach($insumoModel->id, ['cantidad_usada' => $insumo['cantidad']]);
                }
            }
        } else {
            return redirect()->back()->withErrors('No se han seleccionado insumos válidos.');
        }

        // Limpiar la sesión
        session()->forget('insumos_agregados');

        // Redirigir a la lista de productos con éxito

        return redirect()->route('Admin.productos')->with('success', 'Producto creado exitosamente');
    }

    public function show($id)
    {
        $user = auth()->user();

        // Verificar si el permiso 'productos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Productos')
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
        
        $producto = Producto::with('categoria_producto', 'insumos')->findOrFail($id);

        // Retornar la vista con el producto
        return view('Admin.producto.show', compact('producto'));
    }




    public function edit($id)
    {
        $user = auth()->user();

        // Verificar si el permiso 'productos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Productos')
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
        $producto = Producto::find($id);
        $categorias = CategoriaProducto::where('estado', 1)->get();
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
