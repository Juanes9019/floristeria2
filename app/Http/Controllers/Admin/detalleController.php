<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Detalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class detalleController extends Controller
{
    public function index(){
        $detalles = Detalle::all();
        $i = 0; 
        return view('Admin.detalle.index', compact('detalles', 'i'));
    }

    public function getDetalles()
    {
        $detalles = Detalle::all();
        return response()->json($detalles);
    }
}
