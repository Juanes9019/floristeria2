<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Exports\ProveedorExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class ProveedorController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Verificar si el usuario tiene permiso para ver proveedores
    $permiso = DB::table('permisos')
                ->where('nombre', 'proveedores')
                ->first();
                
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    
    }

    // Continuar si tiene el permiso
    $proveedor = Proveedor::all();
    return view('Admin.proveedor.index', compact('proveedor'));
}

    public function create()
    {
        $user = auth()->user();

    // Verificar si el usuario tiene permiso para ver proveedores
    $permiso = DB::table('permisos')
                ->where('nombre', 'proveedores')
                ->first();
                
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }
        $proveedor = new Proveedor();
        return view('Admin.proveedor.create', compact('proveedor'));
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'nombre' => ['required', 'min:4', 'max:255'],
                'telefono' => ['required', 'size:10'],
                'correo' => 'required',
                'ubicacion' => 'required',]
        );


        $proveedor = new Proveedor;
        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;
        $proveedor->ubicacion = $request->ubicacion;

        if ($request->has('estado')) {
            $proveedor->estado = $request->estado;
        } else {

            $proveedor->estado = 1;
        }

        $proveedor->save();

        return redirect()->route('Admin.proveedores')
            ->with('success', 'proveedor creado con éxito.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();

    // Verificar si el usuario tiene permiso para ver proveedores
    $permiso = DB::table('permisos')
                ->where('nombre', 'proveedores')
                ->first();
                
    $tienePermiso = DB::table('permisos_rol')
                    ->where('id_rol', $user->id_rol)
                    ->where('id_permiso', $permiso->id)
                    ->exists();
    
    if (!$tienePermiso) {
        return response()->view('errors.accesoDenegado');
    }

        $proveedor = Proveedor::find($id);
        return view('Admin.proveedor.edit', compact('proveedor'));
    }


    public function update(Request $request, $id)
    {
        // Encuentra al usuario por su ID
        $proveedor = Proveedor::find($id);

        // Validaciones y lógica de actualización
        $request->validate(
            [
                'nombre' => 'required',
                'telefono' => 'required',
                'correo' => 'required|email',
                'ubicacion' => 'required',

            ],
            [
                'nombre.required' => 'El campo :attribute es requerido',
                'nombre.min' => 'El campo :attribute debe tener al menos :min caracteres',
                'nombre.max' => 'El campo :attribute debe ser menor que :max caracteres',
                'telefono.required' => 'El campo :attribute es requerido',
                'telefono.size' => 'El campo :attribute debe tener :size caracteres.',
                'correo.required' => 'El campo :attribute es requerido',
                'ubicacion.required' => 'El campo :attribute es requerido',
            ]
        );

        // Asignación de los campos del usuario desde el formulario
        $proveedor->nombre = $request->input('nombre');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->correo = $request->input('correo');
        $proveedor->ubicacion = $request->input('ubicacion');
        if ($request->has('estado')) {
            $proveedor->estado = $request->estado;
        }

        $proveedor->save();

        // Redireccionar a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.proveedores', ['id' => $proveedor->id])
            ->with('success', 'proveedor actualizado exitosamente');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor->estado == 1) {
            return redirect()->route('Admin.proveedores')
                ->with('error', 'No se puede eliminar un proveedor Activo');
        }

        $proveedor->delete();

        return redirect()->route('Admin.proveedores')
            ->with('success', 'proveedor eliminado con éxito');
    }

    public function export($format)
    {
        $export = new ProveedorExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.proveedores', [
                    'proveedores' => Proveedor::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('proveedores.pdf');
            case 'xlsx':
            default:
                return $export->download('proveedores.xlsx', Excel::XLSX);
        }
    }


    // public function change_Status($id)
    // {
    //     $proveedor = Proveedor::find($id);
    //     if ($proveedor->estado == 1) {
    //         $proveedor->estado = 0;
    //     } else {
    //         $proveedor->estado = 1;
    //     }

    //     $proveedor->save();
    //     return redirect()->back();
    // }
}
