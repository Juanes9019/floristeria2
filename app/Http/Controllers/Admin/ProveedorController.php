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
            ->where('nombre', 'Proveedores')
            ->first();

        $tienePermiso = DB::table('permisos_rol')
            ->where('id_rol', $user->id_rol)
            ->where('id_permiso', $permiso->id)
            ->exists();

        if (!$tienePermiso) {
            return response()->view('errors.accesoDenegado');
        }

        // Continuar si tiene el permiso
        return view('Admin.proveedor.index');
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
        return view('Admin.proveedor.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'tipo' => 'required|string',
            'nombre' => 'required|string|max:255',
            'numero' => 'nullable|int|',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'ubicacion' => 'required|string',
        ]);



        $proveedor = new Proveedor();
        $proveedor->tipo_proveedor = $request->tipo;
        $proveedor->numero_documento = $request->numero;
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
        // Encuentra al proveedor por su ID
        $proveedor = Proveedor::find($id);

        // Validaciones y lógica de actualización
        $request->validate([
            'tipo' => 'required|string',
            'nombre' => 'required|string|max:255',
            'numero' => 'nullable|int',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'ubicacion' => 'required|string',
        ]);

        // Asignación de los campos desde el formulario
        $proveedor->tipo_proveedor = $request->input('tipo');
        $proveedor->nombre = $request->input('nombre');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->correo = $request->input('correo');
        $proveedor->ubicacion = $request->input('ubicacion');

        // Actualizar el estado si se ha enviado
        if ($request->has('estado')) {
            $proveedor->estado = $request->estado;
        }

        // Guardar los cambios
        $proveedor->save();

        // Redireccionar con un mensaje de éxito
        return redirect()->route('Admin.proveedores')
            ->with('success', 'Proveedor actualizado exitosamente');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);
        if ($proveedor->estado == 1) {
            return redirect()->route('Admin.proveedores')
                ->with('error', 'No se puede eliminar un Proveedor Activo');
        }
        try {
            // Intenta eliminar el producto
            $proveedor->delete();
            return redirect()->route('Admin.proveedores')
                ->with('success', 'Proveedor eliminado con éxito');
        } catch (\Illuminate\Database\QueryException $e) {
            // Verifica si el error es por restricción de clave foránea
            if ($e->getCode() === "23000") {
                return redirect()->route('Admin.proveedores')
                    ->with('error', 'No se puede eliminar el producto porque está asociado a una compra.');
            }
            // Lanza la excepción si no es el error esperado
            throw $e;
        }
    }

    public function export($format)
    {
        $export = new ProveedorExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.proveedores', [
                    'proveedores' => Proveedor::all()
                ])->setPaper('a4', 'portait')
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


    public function getProveedor()
    {
        $proveedores = Proveedor::all();
        return response()->json($proveedores);
    }
}
