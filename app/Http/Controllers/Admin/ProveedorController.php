<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        $i = 0; 
        return view('Admin.proveedor.index', compact('proveedores', 'i'));
    }

    public function create()
    {
        $proveedores = new Proveedor();
        return view('Admin.proveedor.create', compact('proveedores'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'ubicacion' => 'required',
        ]);


        $proveedor = new Proveedor;
        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;
        $proveedor->ubicacion = $request->ubicacion;

        $proveedor->save();

        return redirect()->route('Admin.proveedor')
            ->with('success', 'proveedor creado con éxito.');

    }

    public function edit($id){
    $proveedores = Proveedor::find($id);
    return view('Admin.proveedor.edit', compact('proveedores'));
}

    
public function update(Request $request, $id)
{
    // Encuentra al usuario por su ID
    $proveedores = Proveedor::find($id);

    // Validaciones y lógica de actualización
    $request->validate([
        'nombre' => 'required',
        'telefono' => 'required',
        'correo' => 'required|email',
        'ubicacion' => 'required',

    ]);

    // Asignación de los campos del usuario desde el formulario
    $proveedores->nombre = $request->input('nombre');
    $proveedores->telefono = $request->input('telefono');
    $proveedores->correo = $request->input('correo');
    $proveedores->ubicacion = $request->input('ubicacion');

    $proveedores->save();

    // Redireccionar a la vista de edición con un mensaje de éxito
    return redirect()->route('Admin.proveedor', ['id' => $proveedores->id])
        ->with('success', 'proveedor actualizado exitosamente');
}

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        $proveedor->delete();

        return redirect()->route('Admin.proveedor')
            ->with('success', 'proveedor eliminado con éxito');

    }

}
