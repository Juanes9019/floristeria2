<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Permisos_rol;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de roles
        $permiso = DB::table('permisos')
                    ->where('nombre', 'roles')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

        $roles = Roles::all();
        $i = 0; 
        return view('Admin.roles.index', compact('roles', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de roles
        $permiso = DB::table('permisos')
                    ->where('nombre', 'roles')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
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
                return redirect()->route('Admin.permisos_rol');
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
        $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de roles
        $permiso = DB::table('permisos')
                    ->where('nombre', 'roles')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        
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
    return redirect()->route('Admin.permisos_rol', ['id' => $rol->id])
        ->with('success', 'rol actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    try {
        $rol = Roles::find($id);

        if ($rol) {
            $rol->delete();
            return redirect()->route("Admin.permisos_rol")->with('success', 'Rol eliminado exitosamente');
        } else {
            return redirect()->route("Admin.permisos_rol")->with('error', 'No se pudo encontrar la rol');
        }
    } catch (\Exception $e) {
        // Captura cualquier error que ocurra durante la eliminación
        
        return redirect()->route("Admin.permisos_rol")->with('error', 'No se pudo borrar el registro. Es posible que esté siendo utilizado en otra parte del sistema.');
    }
}



public function permisos_rol()
{
    $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de roles
        $permiso = DB::table('permisos')
                    ->where('nombre', 'roles')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

    $roles = Roles::with('permisos')->get(); // Relación 'permisos' debe existir en tu modelo Roles.
    $todos_los_permisos = Permiso::all(); // Obtén todos los permisos para los checkboxes.

    return view('Admin.permisos.index', compact('roles', 'todos_los_permisos'));
}

public function update_permiso_rol(Request $request, $id)
{
    // Validaciones
    $request->validate([
        'nombre_rol' => 'required|string|max:255',
        // Puedes omitir la validación de permisos si quieres permitir que no se envíen
        // 'permisos' => 'array', // Asegúrate de que se envían permisos
    ]);

    // Encuentra el rol
    $role = Roles::findOrFail($id);

    // Actualiza el nombre del rol
    $role->nombre = $request->input('nombre_rol');
    $role->save();

    // Actualiza los permisos asociados al rol
    // Utiliza un array vacío si no se envían permisos
    $permisos = $request->input('permisos', []);
    $role->permisos()->sync($permisos); // Esto ahora actualizará correctamente los permisos

    return redirect()->route('Admin.permisos_rol')->with('success', 'Rol y permisos actualizados correctamente.');
}


}