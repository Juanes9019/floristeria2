<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
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
        $productos = Producto::take(4)->get();


        return view('home', compact('productos'));
    }

    public function dashboard()
    {
        return view('Admin.dashboard');
    }

    public function perfilUser($section = 'edit-info')
    {
        $i = 0; 
        $user = Auth::user();
        $rol = $user->role->nombre;
        $pedidos = Pedido::where('user_id', $user->id)->get();

        return view('view_perfil.perfil', compact ('user','rol','section','pedidos','i'));
    }
    

    public function show($id)
    {
        $productos = Producto::findOrFail($id);

        return view('view_arreglo.arreglo_view', compact('productos'));
    }
}
