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

class Categoria_insumoController extends Controller
{
    public function index()
    {
        $categoria_insumos = Categoria_insumo::all();
        $i = 0; 
        return view('Admin.categoria_insumo.index', compact('categoria_insumos', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $categoria_insumo = new Categoria_insumo();
        $proveedores= DB::table('proveedores')->get();
        return view('Admin.categoria_insumo.create', compact('categoria_insumo','proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'id_proveedor' => 'required',
        ]);


        $categoria_insumos = new Categoria_insumo;
        $categoria_insumos->nombre = $request->nombre;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        
        if ($request->has('estado')) {
            $categoria_insumos->estado = 1;
       }

        $categoria_insumos->save();

        return redirect()->route('Admin.categoria_insumo')
            ->with('success', 'categoria_insumo creada con éxito.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categoria_insumo = Categoria_insumo::find($id);
        $proveedores= DB::table('proveedores')->get();
        return view('Admin.categoria_insumo.edit', compact('categoria_insumo','proveedores'));
    }

    
public function update(Request $request, $id)
{
    // Encuentra al usuario por su ID
    $categoria_insumos = Categoria_insumo::find($id);

    // Validaciones y lógica de actualización
    $request->validate([
        'nombre' => 'required',
        'id_proveedor' => 'required',

    ]);

    // Asignación de los campos del usuario desde el formulario
    $categoria_insumos->nombre = $request->input('nombre');
    $categoria_insumos->id_proveedor = $request->input('id_proveedor');

    if ($request->has('estado')) {
        $categoria_insumos->estado = $request->estado;
    }

    $categoria_insumos->save();

    // Redireccionar a la vista de edición con un mensaje de éxito
    return redirect()->route('Admin.categoria_insumo', ['id' => $categoria_insumos->id])
        ->with('success', 'categoria_insumo actualizada exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria_insumos = Categoria_insumo::find($id);

        $categoria_insumos->delete();

        return redirect()->route('Admin.categoria_insumo')
            ->with('success', 'categoria_insumo eliminada con éxito');

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

}
