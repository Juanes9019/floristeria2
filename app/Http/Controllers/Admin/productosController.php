<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_Producto;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class productosController extends Controller
{
    public function index()
    {
        $user = auth()->user();

    // Verificar si el permiso 'productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'productos')
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

    public function create()
    {
        $user = auth()->user();

    // Verificar si el permiso 'productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'productos')
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
        $producto = new Producto(); 
        $categorias = Categoria_Producto::all();
        return view('Admin.producto.create', compact('categorias','producto'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'id_categoria_producto' => 'required',
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

        $producto->id_categoria_producto = $request->id_categoria_producto;
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
        $user = auth()->user();

    // Verificar si el permiso 'productos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'productos')
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
        $categorias = Categoria_Producto::all();
        return view('Admin.producto.edit', compact('producto','categorias'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $producto = Producto::find($id);
        

        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria_producto' => 'required|exists:categorias_productos,id_categoria_producto',
            'nombre' => 'required|string',
            'descripcion' => 'required',
            'cantidad' => 'required|integer',
            'precio' => 'required|numeric',
            'foto' => 'required', 
        ]);

        // Asignación de los campos del usuario desde el formulario
        $producto->id_categoria_producto = $request->input('id_categoria_producto');
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->cantidad = $request->input('cantidad');
        $producto->precio = $request->input('precio');
        $producto->foto = $request->input('foto');
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
