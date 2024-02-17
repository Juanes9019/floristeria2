<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::all();
        $i = 0; 
        return view('Admin.categoria.index', compact('categorias', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $data = $request->validate([
            'nombre' => 'required',
        ]);
    
        // Intentar insertar en la base de datos
        try {
            $result = DB::table('categorias')->insert([
                'nombre' => $data['nombre'],
            ]);
    
            // Log del resultado de la inserción
            Log::info('Resultado de la inserción: ' . ($result ? 'Éxito' : 'Fallo'));
    
            if ($result) {
                // Log para verificar que intentó redirigir
                Log::info('Intentando redireccionar');
                return redirect()->route('Admin.categoria');
            } else {
                dd('Error al insertar en la base de datos');
            }
        } catch (\Exception $e) {
            // Log del error
            Log::error('Error al insertar en la base de datos: ' . $e->getMessage());
        
            // Imprimir el mensaje de la excepción para obtener más detalles
            dd('Error al insertar en la base de datos: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);

        return view('Admin.categoria.edit',['categoria' => $categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Encuentra la categoria por su ID
    $categoria = Categoria::find($id);

    // Validaciones y lógica de actualización
    $request->validate([
        'nombre' => 'required|min:5',
    ]);

    // Actualiza los campos de la categoria utilizando el método save
    $categoria->nombre = $request->input('nombre');
    $categoria->save();

    // Redirecciona a la vista de edición con un mensaje de éxito
    return redirect()->route('Admin.categoria', ['id' => $categoria->id])
        ->with('success', 'categoria actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria = Categoria::find($id);
    
        if ($categoria) {
            $categoria->delete();
            return redirect()->route("Admin.categoria")->with('success', 'categoria eliminada exitosamente');
        } else {
            // Puedes manejar el caso donde el producto no se encuentra
            return redirect()->route("Admin.categoria")->with('error', 'No se pudo encontrar la categoria');
        }
    }
}
