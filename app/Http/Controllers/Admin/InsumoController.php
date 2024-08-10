<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InsumoController extends Controller
{
    public function index(){
        $insumos = Insumo::all();
        $i = 0; 
        return view('Admin.insumo.index', compact('insumos', 'i'));
    }

    public function create()
    {
        $sub_categoria= DB::table('sub_categorias')->pluck('nombre', 'id');
        return view('Admin.insumo.create', compact('sub_categoria'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $data = $request->validate([
            'id_categoria_insumo' => 'required',
            'cantidad_insumo' => 'required',
            'precio' => 'required',
            'perdida_insumo' => 'required',
        ]);

        $insumo = new Insumo;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        $insumo->cantidad_insumo = $request->cantidad_insumo;
        $insumo->precio = $request->precio;
        $insumo->perdida_insumo = $request->perdida_insumo;

        $insumo->save();

        return redirect()->route('Admin.insumo')
            ->with('success', 'insumo creado con éxito.');
    
        // // Intentar insertar en la base de datos
        // try {
        //     $result = DB::table('insumos')->insert([
        //         'id_categoria_insumo' => $data['id_categoria_insumo'],
        //         'cantidad_insumo' => $data['cantidad_insumo'],
        //         'precio' => $data['precio'],
        //         'perdida_insumo' => $data['perdida_insumo'],
        //     ]);
    
        //     // Log del resultado de la inserción
        //     Log::info('Resultado de la inserción: ' . ($result ? 'Éxito' : 'Fallo'));
    
        //     if ($result) {
        //         // Log para verificar que intentó redirigir
        //         Log::info('Intentando redireccionar');
        //         return redirect()->route('Admin.insumo');
        //     } else {
        //         dd('Error al insertar en la base de datos');
        //     }
        // } catch (\Exception $e) {
        //     // Log del error
        //     Log::error('Error al insertar en la base de datos: ' . $e->getMessage());
        
        //     // Imprimir el mensaje de la excepción para obtener más detalles
        //     dd('Error al insertar en la base de datos: ' . $e->getMessage());
        // }
    }

    public function edit($id)    {
        $insumos = Insumo::find($id);
        $sub_categoria= DB::table('sub_categorias')->pluck('nombre', 'id');
        return view('Admin.insumo.edit', compact('insumos','sub_categoria'));
    }

    public function update(Request $request, $id)
    {
        // Encuentra la categoria por su ID
        $insumos = Insumo::find($id);

        // Validaciones y lógica de actualización
        $request->validate([
            'id_categoria_insumo' => 'required',
            'cantidad_insumo' => 'required',
            'precio' => 'required',
            'perdida_insumo' => 'required',

        ]);

        // Asignación de los campos del usuario desde el formulario
        $insumos->id_categoria_insumo = $request->input('id_categoria_insumo');
        $insumos->cantidad_insumo = $request->input('cantidad_insumo');
        $insumos->precio = $request->input('precio');
        $insumos->perdida_insumo = $request->input('perdida_insumo');

        $insumos->save();

        // Redirecciona a la vista de edición con un mensaje de éxito
        return redirect()->route('Admin.insumo', ['id' => $insumos->id])
        ->with('success', 'categoria actualizado exitosamente');
    }

    public function destroy($id)
    {
        $insumo = Insumo::find($id);

        $insumo->delete();

        return redirect()->route('Admin.insumo')
            ->with('success', 'proveedor eliminado con éxito');

    }
}


