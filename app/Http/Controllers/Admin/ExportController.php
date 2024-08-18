<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Pedido;

class ExportController extends Controller
{
    public function exportarPDF()
    {
        $pedidos = Pedido::all(); 

        $pdf = PDF::loadView('pdf.export_pedidos', compact('pedidos'));

        return $pdf->download('pedidos.pdf');
    }
}
