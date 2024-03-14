<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;


class productosController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        $i = 0; 
        return view('Admin.producto.index', compact('productos', 'i'));
    }
}
