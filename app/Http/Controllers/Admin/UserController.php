<?php

namespace App\Http\Controllers\Admin;

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


class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        $i = 0; 
        return view('Admin.users.index', compact('usuarios', 'i'));
    }

    public function create()
    {
        $user = new User();
        return view('Admin.users.create', compact('user'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'celular' => 'required',
            'direccion' => 'required',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
        ]);


        $user = new User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->celular = $request->celular;
        $user->direccion = $request->direccion;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('Admin.users')
            ->with('success', 'usuario creado con éxito.');

    }

    public function edit($id)
{
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

        $user->delete();

        return redirect()->route('Admin.users')
            ->with('success', 'Usuario eliminado con éxito');

    }

    public function index_pqrs()
    {
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


        return redirect()->route('Admin.users.pqrs')->with('success', 'Respuesta enviada con éxito');
    } catch (\Exception $e) {
        Log::error('Error al responder la PQRS: ' . $e->getMessage());

        return back()->with('error', 'Error al responder la PQRS: ' . $e->getMessage());
    }
}

}
