<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventario;


class inventarioController extends Controller
{
    public function index(){
        $inventario = Inventario::all();
        $i = 0; 
        return view('Admin.inventario.index', compact('inventario', 'i'));
    }
}
