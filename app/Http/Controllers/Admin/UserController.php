<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsuarioExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pqrs;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de usuarios
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Usuarios')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
    
        // Si tiene permiso, proceder a obtener los usuarios
        $usuarios = User::all();
        
        return view('Admin.users.index', compact('usuarios'));
    }
    

    public function create()
    {
        $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de usuarios
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Usuarios')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

        $user = new User();
        
        $roles = Roles::all();
        return view('Admin.users.create', compact('user','roles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users,email',
            'celular' => 'required',
            'direccion' => 'required',
            'id_rol' => 'required',
            'password' => ['required', 'string', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
            'cpassword' => ['required', 'same:password']
        ]);
        


        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->celular = $request->celular;
        $user->direccion = $request->direccion;
        $user->id_rol = $request->id_rol;
        $user->password = Hash::make($request->password);

        $user->save();
        
    

        return redirect()->route('Admin.users')
            ->with('success', 'Usuario creado con éxito.');

    }

    public function edit($id)
{
    $user = auth()->user();
    
        // Verificar si el usuario tiene permiso para ver la vista de usuarios
        $permiso = DB::table('permisos')
                    ->where('nombre', 'Usuarios')
                    ->first();
                    
        $tienePermiso = DB::table('permisos_rol')
                        ->where('id_rol', $user->id_rol)
                        ->where('id_permiso', $permiso->id)
                        ->exists();
        
        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }
        
    $usuarios = User::find($id);
    $roles = Roles::all();

    return view('Admin.users.edit', compact('usuarios','roles'));
}

    
public function update(Request $request, $id)
{
    // Encuentra al usuario por su ID
$usuarios = User::find($id);

// Validaciones y lógica de actualización
$request->validate([
    'name' => 'required',
    'surname' => 'required',
    'email' => 'required|email',
    'celular' => 'required',
    'direccion' => 'required',
    'id_rol' => 'required',
    'password' => ['nullable', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
]);

// Asignación de los campos del usuario desde el formulario
$usuarios->name = $request->input('name');
$usuarios->surname = $request->input('surname');
$usuarios->email = $request->input('email');
$usuarios->celular = $request->input('celular');
$usuarios->direccion = $request->input('direccion');
$usuarios->id_rol = $request->input('id_rol');
$usuarios->password = $request->input('password');

// Si el campo 'type' está presente en la solicitud, asigna el nuevo valor
if ($request->has('type')) {
    $usuarios->type = $request->input('type') == 'admin' ? 1 : 0;
}

// Guardar los cambios en la base de datos
$usuarios->save();

// Redireccionar a la vista de edición con un mensaje de éxito
return redirect()->route('Admin.users', ['id' => $usuarios->id])
    ->with('success', 'Usuario actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user->estado == 0){
            $user->delete();
            return redirect()->route('Admin.users')
            ->with('success', 'Usuario eliminado con éxito');
        }
        else{
            return redirect()->route('Admin.users')
            ->with('error', 'El usuario solo se puede eliminar si está inactivo');
        }

        

 
    }

    public function index_pqrs()
    {
        $user = auth()->user();

    // Verificar si el permiso 'pqrs' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Pqrs')
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

        $pqrs = Pqrs::all();
        $i = 0; 
        $fecha = now()->format('Y-m-d');
        return view('Admin.pqrs.index', compact('pqrs','fecha' ,'i'));
    }
    


    public function responderPqrs(Request $request, $id)
    {
    $data = $request->validate([
        'respuesta' => 'required',
    ]);

    try {
        $pqrs = Pqrs::findOrFail($id);

        $pqrs->respuesta = $data['respuesta'];
        $pqrs->fecha_respuesta = now();
        $pqrs->estado = 'Respondido'; 
        $pqrs->save();

        $user = auth()->user();

    // Verificar si el permiso 'pqrs' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Pqrs')
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


        return redirect()->route('Admin.users.pqrs')->with('success', 'Respuesta enviada con éxito');
    } catch (\Exception $e) {
        Log::error('Error al responder la PQRS: ' . $e->getMessage());

        return back()->with('error', 'Error al responder la PQRS: ' . $e->getMessage());
    }
}
public function export($format)
    {
        $export = new UsuarioExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.usuarios', [
                    'usuarios' => User::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('usuarios.pdf');
            case 'xlsx':
            default:
                return $export->download('usuarios.xlsx', Excel::XLSX);
        }
    }
    public function login(Request $request)
    {
        // Validar las credenciales
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($request->only('email', 'password'))) {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Retornar los datos del usuario, incluyendo el rol
            return response()->json([
                'role' => $user->role,
                'message' => 'Inicio de sesión exitoso',
            ], 200);
        }

        // Si las credenciales son incorrectas
        return response()->json([
            'message' => 'Credenciales incorrectas',
      ],401);
    }
}
