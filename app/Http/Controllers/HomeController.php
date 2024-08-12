<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;
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

    public function perfilUser()
    {
        $user = Auth::user();

        return view('perfil', compact ('user'));
    }
    

    public function show($id)
    {
        $productos = Producto::findOrFail($id);

        return view('view_arreglo.arreglo_view', compact('productos'));
    }
}
