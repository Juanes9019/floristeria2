<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Insumo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Categoria_insumo;

class InsumoController extends Controller
{
    public function index(){
        $insumos = Insumo::all();
        $i = 0; 
        return view('Admin.insumo.index', compact('insumos', 'i'));
    }

    public function create()
    {
        $categoria_insumo= DB::table('categoria_insumos')->pluck('nombre', 'id');
        return view('Admin.insumo.create', compact('categoria_insumo'));
    }

    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $data = $request->validate([
            'id_categoria_insumo' => 'required',
            'cantidad_insumo' => 'required',
            'costo_unitario' => 'required',
            'perdida_insumo' => 'required',
            // 'costo_total' => 'required',
        ]);

        $insumo = new Insumo;
        $insumo->id_categoria_insumo = $request->id_categoria_insumo;
        $insumo->cantidad_insumo = $request->cantidad_insumo;
        $insumo->costo_unitario = $request->costo_unitario;
        $insumo->perdida_insumo = $request->perdida_insumo;
        $insumo->costo_total = $request->costo_unitario * $request->cantidad_insumo;

        if ($request->has('estado')) {
            $insumo->estado = 1;
       }


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
            'cantidad_insumo' => 'required',
            'costo_unitario' => 'required',
            'perdida_insumo' => 'required',
            // 'costo_total' => 'required',
        ]);

        //Calcula la nueva cantidad restando la pérdida
        $nueva_cantidad = $insumos->cantidad_insumo - $request->input('perdida_insumo');

        // Asignación de los campos del usuario desde el formulario
        $insumos->id_categoria_insumo = $request->input('id_categoria_insumo');
        $insumos->cantidad_insumo = $request -> $nueva_cantidad > 0 ? $nueva_cantidad : 0;
        $insumos->costo_unitario = $request->input('costo_unitario');
        $insumos->perdida_insumo = $request->input('perdida_insumo');
        $insumos->costo_total = $request->costo_unitario * $request->cantidad_insumo;
        if ($request->has('estado')) {
            $insumos->estado = $request->estado;
        }

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
            ->with('success', 'Insumo eliminado con éxito');

    }

    public function incrementarInsumo($id)
{
    $insumo = Insumo::find($id);
    
    // Incrementa la pérdida de insumo en 1
    $insumo->perdida_insumo += 1;
    
    // Reduce la cantidad de insumo en 1
    $insumo->cantidad_insumo = max(0, $insumo->cantidad_insumo - 1);
    
    $insumo->save();

    return redirect()->route('Admin.insumo')->with('success', 'Insumo actualizado con éxito.');
}
    
public function decrementarInsumo($id)
{
    $insumo = Insumo::find($id);
    
    // Decrementa la pérdida de insumo en 1, asegurando que no sea menor que 0
    if ($insumo->perdida_insumo > 0) {
        $insumo->perdida_insumo -= 1;
        $insumo->cantidad_insumo += 1; // Aumenta la cantidad de insumo
    }

    $insumo->save();

    return redirect()->route('Admin.insumo')->with('success', 'Insumo actualizado con éxito.');
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

}