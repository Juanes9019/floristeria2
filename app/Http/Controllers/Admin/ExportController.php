<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\Pedido;
use App\Models\Detalle;
use App\Models\Producto;

class ExportController extends Controller
{
    public function exportarPDF()
    {
        $pedidos = Pedido::all(); 

        $pdf = PDF::loadView('pdf.export_pedidos', compact('pedidos'));

        return $pdf->download('pedidos.pdf');
    }

    public function exportar_detalle()
    {
        $detalle = Detalle::all(); 

        $pdf = PDF::loadView('pdf.export_detalle', compact('detalle'));

        return $pdf->download('detalle.pdf');
    }

    public function exportar_producto()
    {
        $producto = Producto::all(); 

        $pdf = PDF::loadView('pdf.export_productos', compact('producto'));

        return $pdf->download('producto.pdf');
    }
}
