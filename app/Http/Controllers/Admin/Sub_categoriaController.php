<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sub_categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class Sub_categoriaController extends Controller
{
    public function index()
    {
        $sub_categorias = Sub_categoria::all();
        $i = 0; 
        return view('Admin.sub_categoria.index', compact('sub_categorias', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sub_categorias = new Sub_categoria();
        return view('Admin.sub_categoria.create', compact('sub_categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
        ]);


        $sub_categorias = new Sub_categoria;
        $sub_categorias->nombre = $request->nombre;

        $sub_categorias->save();

        return redirect()->route('Admin.sub_categoria')
            ->with('success', 'sub_categoria creada con éxito.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $sub_categorias = Sub_categoria::find($id);



    return view('Admin.sub_categoria.edit', compact('sub_categorias'));


}

    
public function update(Request $request, $id)
{
    // Encuentra al usuario por su ID
    $sub_categorias = Sub_categoria::find($id);

    // Validaciones y lógica de actualización
    $request->validate([
        'nombre' => 'required',

    ]);

    // Asignación de los campos del usuario desde el formulario
    $sub_categorias->nombre = $request->input('nombre');

    $sub_categorias->save();

    // Redireccionar a la vista de edición con un mensaje de éxito
    return redirect()->route('Admin.sub_categoria', ['id' => $sub_categorias->id])
        ->with('success', 'sub_categoria actualizada exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sub_categorias = Sub_categoria::find($id);

        $sub_categorias->delete();

        return redirect()->route('Admin.sub_categoria')
            ->with('success', 'sub_categoria eliminada con éxito');

    }

}
