<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Categoria_insumo;
use App\Exports\InsumoExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;
use App\Models\HistorialPerdida;


class InsumoController extends Controller
{
    public function index(){

        $user = auth()->user();

    // Verificar si el permiso 'insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'insumos')
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

        $insumos = Insumo::all();
        $i = 0; 
        return view('Admin.insumo.index', compact('insumos', 'i'));
    }

    public function create()
    {
        $user = auth()->user();

    // Verificar si el permiso 'insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'insumos')
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

        $categoria_insumo= DB::table('categoria_insumos')->pluck('nombre', 'id');
        return view('Admin.insumo.create', compact('categoria_insumo'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $data = $request->validate([
            'id_categoria_insumo' => 'required',
            'nombre' => 'required',
            'costo_unitario' => 'required',
            'imagen' => 'required',
        ]);

        $insumo = new Insumo;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        $insumo->nombre = $request->nombre;
        $insumo->cantidad_insumo = 0;
        $insumo->costo_unitario = $request->costo_unitario;
        $insumo->perdida_insumo = 0;
        $insumo->costo_perdida = $request->costo_unitario * $request->perdida_insumo;
        $insumo->imagen = $request->imagen;

        if ($request->has('estado')) {
            $insumo->estado = 1;
       }


        $insumo->save();

        return redirect()->route('Admin.insumo')
            ->with('success', 'insumo creado con éxito.');
    
    }

    public function edit($id)    {
        $user = auth()->user();

    // Verificar si el permiso 'insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'insumos')
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
        $insumos = Insumo::find($id);
        $categoria_insumos = DB::table('categoria_insumos')->get();
        return view('Admin.insumo.edit', compact('insumos','categoria_insumos'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $insumos = Insumo::find($id);

        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria_insumo' => 'required',
            'nombre' => 'required',
            'costo_unitario' => 'required',
            'imagen' => 'required',
        ]);

        // Asignación de los campos del usuario desde el formulario
        $insumos->id_categoria_insumo = $request->input('id_categoria_insumo');
        $insumos->nombre = $request->input('nombre');
        $insumos->costo_unitario = $request->input('costo_unitario');
        $insumos->imange = $request->input('imagen');
        if ($request->has('estado')) {
            $insumos->estado = $request->estado;
        }
        

        $insumos->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.insumo', ['id' => $insumos->id])
        ->with('success', 'insumo actualizado exitosamente');
    }

    // public function incrementarInsumo($id)
    // {
    //     $insumo = Insumo::find($id);
        
    //     // Verifica si la cantidad de insumo es mayor a 0 antes de incrementar la pérdida
    //     if ($insumo->cantidad_insumo > 0) {
    //         // Incrementa la pérdida de insumo en 1
    //         $insumo->perdida_insumo += 1;
        
    //         // Reduce la cantidad de insumo en 1
    //         $insumo->cantidad_insumo = max(0, $insumo->cantidad_insumo - 1);
    //         $insumo->costo_perdida = $insumo->costo_unitario * $insumo->perdida_insumo;
    //         $insumo->save();
        
    //         return redirect()->route('Admin.insumo')->with('success', 'Insumo incrementado.');
    //     } else {
    //         return redirect()->route('Admin.insumo')->with('error', 'No se puede incrementar la pérdida, la cantidad de insumo es 0.');
    //     }
    // }
    
    
    // public function decrementarInsumo($id)
    // {
    //     $insumo = Insumo::find($id);
        
    //     // Solo decrementa la pérdida y aumenta la cantidad si la pérdida es mayor que 0
    //     if ($insumo->perdida_insumo > 0) {
    //         // Decrementa la pérdida de insumo en 1
    //         $insumo->perdida_insumo -= 1;
    
    //         // Aumenta la cantidad de insumo en 1 solo si la cantidad era 0 antes de este incremento
    //         $insumo->cantidad_insumo += 1;
    //         $insumo->costo_perdida = $insumo->costo_unitario * $insumo->perdida_insumo;
    //         $insumo->save();
        
    //         return redirect()->route('Admin.insumo')->with('success', 'Insumo decrementado.');
    //     } else {
    //         return redirect()->route('Admin.insumo')->with('error', 'No se puede decrementar la pérdida, no hay pérdida registrada.');
    //     }
    // }
    

    public function change_Status($id)
    {
        $insumo = Insumo::find($id);
        if ($insumo->estado == 1) {
            $insumo->estado = 0;
        } else {
            $insumo->estado = 1;
        }

        $insumo->save();
        return redirect()->back();
    }

    public function export($format)
    {
        $export = new InsumoExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.insumos', [
                    'insumos' => Insumo::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('insumos.pdf');
            case 'xlsx':
            default:
                return $export->download('insumos.xlsx', Excel::XLSX);
        }
    }

    // public function destroy($id)
    // {
    //     $insumo = Insumo::find($id);

    //     if ($insumo->estado == 1) {
    //         return redirect()->route('Admin.insumo')
    //             ->with('error', 'No se puede eliminar un insumo Activa');
    //     }
    //     try {
    //         $insumo->delete();
    //         return redirect()->route('Admin.insumo')
    //             ->with('success','Insumo eliminado con éxito');
    //     } catch (\Illuminate\Database\QueryException $e) {
    //             if ($e->getCode() == 23000) {
    //                 return redirect()->route('Admin.insumo')
    //                     ->with('error', 'No se puede eliminar el insumo porque está asociado a una compra.');
    //             }
    //             return redirect()->route('Admin.insumo')
    //                 ->with('error', 'Error al intentar eliminar el insumo.');
    //     }     
    // }

    public function perdida()
    {
        $insumos = Insumo::all(); // Por ejemplo, para mostrar los insumos.
        
        return view('admin.insumo.perdida', compact('insumos'));
    }

    public function storePerdida(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'insumo_id' => 'required|exists:insumos,id',
            'cantidad_perdida' => 'required|numeric|min:1',
        ]);

        // Obtener el insumo
        $insumo = Insumo::find($request->insumo_id);

        // Verificar que la cantidad perdida no sea mayor a la cantidad disponible
        if ($insumo->cantidad_insumo < $request->cantidad_perdida) {
            return back()->with('error', 'No puedes registrar una pérdida mayor a la cantidad disponible.');
        }

        // Registrar la pérdida en el historial
        HistorialPerdida::create([
            'insumo_id' => $request->insumo_id,
            'cantidad_perdida' => $request->cantidad_perdida,
            'fecha_perdida' => now(),
        ]);

        // Actualizar la cantidad de insumo en la tabla de insumos
        $insumo->cantidad_insumo -= $request->cantidad_perdida;
        $insumo->save();

        return redirect()->route('Admin.insumo.historialPerdidas')->with('success', 'Pérdida registrada con éxito');
    }


    public function historialPerdidas()
    {
        $historialPerdidas = HistorialPerdida::with('insumo')->get();
        return view('admin.insumo.historial_perdidas', compact('historialPerdidas'));
    }


    
}