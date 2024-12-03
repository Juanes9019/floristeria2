<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Categoria_insumo;
use App\Exports\InsumoExport;
use App\Exports\PerdidaExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;
use App\Models\HistorialPerdida;


class InsumoController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        // Verificar si el permiso 'insumos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Insumos')
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
            ->where('nombre', 'Insumos')
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

        $categoria_insumo = DB::table('categoria_insumos')->pluck('nombre', 'id');
        return view('Admin.insumo.create', compact('categoria_insumo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_categoria_insumo' => 'required',
            'nombre' => 'required|min:3|max:20',
            'color' => 'required|min:3|max:15',
            'costo_unitario' => 'required|min:3|max:10', 
            'imagen' => 'required|mimes:jpg,jpeg,png',
        ]);

        $insumo = new Insumo;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        $insumo->nombre = $request->nombre;
        $insumo->color = $request->color;
        $insumo->cantidad_insumo = 0;
        $insumo->costo_unitario = $request->costo_unitario;
        $insumo->imagen = $request->imagen;

        if ($request->has('estado')) {
            $insumo->estado = 1;
        }


        $insumo->save();

        return redirect()->route('Admin.insumo')
            ->with('success', 'insumo creado con éxito.');
    }

    public function edit($id)
    {
        $user = auth()->user();

        // Verificar si el permiso 'insumos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Insumos')
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
        return view('Admin.insumo.edit', compact('insumos', 'categoria_insumos'));
    }

    public function update(Request $request, $id)
    {
        $insumos = Insumo::find($id);

        $request->validate([
            'id_categoria_insumo' => 'required',
            'color' => 'required|min:3|max:15',
            'nombre' => 'required|min:3|max:20',
            'costo_unitario' => 'required|min:3|max:10',
            'imagen' => 'required|mimes:jpg,jpeg,png',
        ]);

        $insumos->id_categoria_insumo = $request->input('id_categoria_insumo');
        $insumos->nombre = $request->input('nombre');
        $insumos->color = $request->input('color');
        $insumos->costo_unitario = $request->input('costo_unitario');
        $insumos->imagen = $request->input('imagen');
        if ($request->has('estado')) {
            $insumos->estado = $request->estado;
        }


        $insumos->save();

        return redirect()->route('Admin.insumo', ['id' => $insumos->id])
            ->with('success', 'insumo actualizado exitosamente');
    }

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
                ])->setPaper('a4', 'portait') 
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

    public function exportPerdida($format)
    {
        $export = new PerdidaExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.perdidas', [
                    'perdidas' => HistorialPerdida::all()
                ])->setPaper('a4', 'portait') 
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('Perdidas.pdf');
            case 'xlsx':
            default:
                return $export->download('Perdidas.xlsx', Excel::XLSX);
        }
    }


    public function perdida()
    {
        $user = auth()->user();

        // Verificar si el permiso 'insumos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Insumos')
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
        $categorias = Categoria_insumo::all();

        return view('admin.insumo.perdida', compact('categorias', 'insumos'));
    }

    public function storePerdida(Request $request)
    {
        try {

            $request->validate([
                'id_categoria_insumo' => 'required',
                'insumo_id' => 'required|exists:insumos,id',
                'cantidad_perdida' => 'required|numeric|min:1',
                'descripcion' => 'required|min:4|max:200'
            ]);

            // Obtener el insumo
            $insumo = Insumo::find($request->insumo_id);

            if ($insumo->cantidad_insumo < $request->cantidad_perdida) {
                return back()->with('error', 'No puedes registrar una pérdida mayor a la cantidad disponible.');
            }

            HistorialPerdida::create([
                'id_categoria_insumo'=> $request->id_categoria_insumo,
                'insumo_id' => $request->insumo_id,
                'cantidad_perdida' => $request->cantidad_perdida,
                'fecha_perdida' => now(),
                'descripcion' => $request->descripcion,
                'costoPerdida' => $request-> cantidad_perdida * $insumo->costo_unitario
            ]);

            $insumo->cantidad_insumo -= $request->cantidad_perdida;
            $insumo->save();
            $user = auth()->user();

            // Verificar si el permiso 'insumos' existe
            $permiso = DB::table('permisos')
                ->where('nombre', 'Insumos')
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

            return redirect()->route('Admin.insumo.historialPerdidas')->with('success', 'Pérdida registrada con éxito');

        }   catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un error al procesar la perdida: ' . $e->getMessage());
        }
    }

    public function historialPerdidas()
    {
        $user = auth()->user();

        // Verificar si el permiso 'insumos' existe
        $permiso = DB::table('permisos')
            ->where('nombre', 'Insumos')
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
        $historialPerdidas = HistorialPerdida::with('insumo')->get();
        return view('admin.insumo.historial_perdidas', compact('historialPerdidas'));
    }

    public function getInsumos($idCategoria)
    {
        $insumos = Insumo::where('id_categoria_insumo', $idCategoria)->get();

        return response()->json($insumos);
    }

    public function obtenerInsumos($idCategoria)
    {
        $insumos = Insumo::where('id_categoria_insumo', $idCategoria)
                        ->select('id', 'nombre', 'color', 'costo_unitario') // Solo seleccionamos los campos necesarios
                        ->get();

        return response()->json($insumos);
    }

    public function todosInsumos()
    {
        $insumos = Insumo::all();
        return response()->json($insumos);
    }
    
}
