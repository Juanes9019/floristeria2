<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria_insumo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;
use App\Exports\CategoriaExport;


class Categoria_insumoController extends Controller
{
    public function index()
    {
        $user = auth()->user();

    // Verificar si el permiso 'Categoria de insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Categoria de insumos')
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
        $categoria_insumos = Categoria_insumo::all();
        $i = 0; 
        return view('Admin.categoria_insumo.index', compact('categoria_insumos', 'i'));
    }

    public function create()
    {
        $user = auth()->user();

    // Verificar si el permiso 'categoria_insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Categoria de insumos')
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
        $categoria_insumo = new Categoria_insumo();
        $proveedores= DB::table('proveedores')->get();
        return view('Admin.categoria_insumo.create', compact('categoria_insumo','proveedores'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|min:3|max:20',
        ]);


        $categoria_insumos = new Categoria_insumo;
        $categoria_insumos->nombre = $request->nombre;
        
        if ($request->has('estado')) {
            $categoria_insumos->estado = 1;
       }

        $categoria_insumos->save();

        return redirect()->route('Admin.categoria_insumo')
            ->with('success', 'categoria  perra insumo creada con éxito.');

    }

    public function edit($id)
    {
        $user = auth()->user();

    // Verificar si el permiso 'categoria_insumos' existe
    $permiso = DB::table('permisos')
                ->where('nombre', 'Categoria de insumos')
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
        $categoria_insumo = Categoria_insumo::find($id);
        $proveedores= DB::table('proveedores')->get();
        return view('Admin.categoria_insumo.edit', compact('categoria_insumo','proveedores'));
    }

    
public function update(Request $request, $id)
{
    $categoria_insumos = Categoria_insumo::find($id);

    $request->validate([
        'nombre' => 'required|min:3|max:20',
    ]);

    $categoria_insumos->nombre = $request->input('nombre');

    if ($request->has('estado')) {
        $categoria_insumos->estado = $request->estado;
    }

    $categoria_insumos->save();

        return redirect()->route('Admin.categoria_insumo', ['id' => $categoria_insumos->id])
            ->with('success', 'categoria insumo perra actualizada exitosamente');
    }

    
    public function destroy($id)
    {
        $categoria_insumo = Categoria_insumo::find($id);

        if ($categoria_insumo->estado == 1) {
            return redirect()->route('Admin.categoria_insumo')
                ->with('error', 'No se puede eliminar una categoria Activa');
        }
        try {
            $categoria_insumo->delete();
            return redirect()->route('Admin.categoria_insumo')
                ->with('success','Categoria eliminada con éxito');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('Admin.categoria_insumo')
                    ->with('error', 'No se puede eliminar la categoría porque está asociada a un insumo.');
            }
            return redirect()->route('Admin.categoria_insumo')
                ->with('error', 'Error al intentar eliminar la categoría.');
        }         
    }

    public function change_Status($id)
    {
        $categoria_insumo = Categoria_insumo::find($id);
        if ($categoria_insumo->estado == 1) {
            $categoria_insumo->estado = 0;
        } else {
            $categoria_insumo->estado = 1;
        }

        $categoria_insumo->save();
        return redirect()->back();
    }

    public function export($format)
    {
        $export = new CategoriaExport;

        switch ($format) {
            case 'pdf':
                $pdf = Pdf::loadView('exports.categorias', [
                    'categorias' => Categoria_insumo::all()
                ])->setPaper('a4', 'portait') // Puedes cambiar a 'portrait' si prefieres
                    ->setOption('margin-left', '10mm')
                    ->setOption('margin-right', '10mm')
                    ->setOption('margin-top', '10mm')
                    ->setOption('margin-bottom', '10mm');
                return $pdf->download('Categoria_insumo.pdf');
            case 'xlsx':
            default:
                return $export->download('Categoria_insumo.xlsx', Excel::XLSX);
        }
    }

    public function getCategoria(){
        $cat = Categoria_insumo::all();
        return response()->json($cat);
    }
    
}
