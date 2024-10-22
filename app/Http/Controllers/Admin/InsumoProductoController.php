<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria_insumo;
use App\Models\Insumo;
use Illuminate\Http\Request;
use App\Models\InsumoProducto;


class InsumoProductoController extends Controller
{
    public function index()
    {
        return view('Admin.insumo_producto.index');
    }
}
