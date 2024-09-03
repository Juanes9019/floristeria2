<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Categoria_Producto;
use App\Models\User;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productos = Producto::all();

        return view('home', compact('productos'));
    }

    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    public function update_informacion(Request $request)
    {
        // Obtener el usuario autenticado
        $usuario = auth()->user();
    
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|min:3',
            'surname' => 'required|min:4',
            'celular' => 'required|min:6',
            'direccion' => 'required|min:4',
        ]);
    
        // Actualizar la información del usuario
        $usuario->name = $request->input('name');
        $usuario->surname = $request->input('surname');
        $usuario->celular = $request->input('celular');
        $usuario->direccion = $request->input('direccion');
        $usuario->save();
    
        // Redirecciona a la vista de perfil con un mensaje de éxito
        return redirect()->route('perfilUser', ['section' => 'edit-info'])->with('success', 'Usuario actualizado exitosamente');
    }
    
    

    public function perfilUser($section = 'edit-info')
    {
        $i = 0; 
        $user = Auth::user();
        $rol = $user->role->nombre;
        $pedidos = Pedido::where('user_id', $user->id)->get();
        
        $activeSection = $section;
    
        return view('view_perfil.perfil', compact('user', 'rol', 'section', 'pedidos', 'i', 'activeSection'));
    }
    

    public function show($id)
    {
        $productos = Producto::findOrFail($id);

        return view('view_arreglo.arreglo_view', compact('productos'));
    }


    public function show_all()
    {
        $productos = Producto::all();
        $categoria_categoria = Categoria_Producto::all();

        return view('view_arreglo.all_products', compact('productos','categoria_categoria'));
    }

    public function productos_filtrar()
    {
        $productos = Producto::all();
        $categoria_categoria = Categoria_Producto::all();

        return view('view_arreglo.all_products', compact('productos','categoria_categoria'));
    }
}
