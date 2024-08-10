<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Roles::all();
        $i = 0; 
        return view('Admin.roles.index', compact('roles', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.roles.create');
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
            $result = DB::table('roles')->insert([
                'nombre' => $data['nombre'],
            ]);
    
            // Log del resultado de la inserción
            Log::info('Resultado de la inserción: ' . ($result ? 'Éxito' : 'Fallo'));
    
            if ($result) {
                // Log para verificar que intentó redirigir
                Log::info('Intentando redireccionar');
                return redirect()->route('Admin.roles');
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
        $rol = Roles::findOrFail($id);

        return view('Admin.roles.edit',['roles' => $rol]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Encuentra la categoria por su ID
    $rol = Roles::find($id);

    // Validaciones y lógica de actualización
    $request->validate([
        'nombre' => 'required|min:5',
    ]);

    // Actualiza los campos de la rol utilizando el método save
    $rol->nombre = $request->input('nombre');
    $rol->save();

    // Redirecciona a la vista de edición con un mensaje de éxito
    return redirect()->route('Admin.roles', ['id' => $rol->id])
        ->with('success', 'rol actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rol = Roles::find($id);
    
        if ($rol) {
            $rol->delete();
            return redirect()->route("Admin.roles")->with('success', 'rol eliminada exitosamente');
        } else {
            // Puedes manejar el caso donde el producto no se encuentra
            return redirect()->route("Admin.roles")->with('error', 'No se pudo encontrar la rol');
        }
    }
}
