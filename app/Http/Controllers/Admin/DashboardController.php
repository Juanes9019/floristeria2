<?php

namespace App\Http\Controllers\Admin;

use App\Models\Compra; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        // Ejemplo de consulta para obtener el total de compras por mes usando 'costo_total'
        $comprasPorMes = Compra::selectRaw('YEAR(created_at) as año, MONTH(created_at) as mes, SUM(costo_total) as total')
                                ->groupBy('año', 'mes')
                                ->orderBy('año')
                                ->orderBy('mes')
                                ->get();

        // Preparar los datos para el primer gráfico
        $comprasData1 = $comprasPorMes->map(function ($compra) {
            return [
                'fecha' => $compra->año . '-' . str_pad($compra->mes, 2, '0', STR_PAD_LEFT), // Formato YYYY-MM
                'total' => $compra->total,
            ];
        });

        // Preparar los datos para el segundo gráfico (si son diferentes)
        $comprasData2 = $comprasPorMes->map(function ($compra) {
            return [
                'fecha' => $compra->año . '-' . str_pad($compra->mes, 2, '0', STR_PAD_LEFT), // Formato YYYY-MM
                'total' => $compra->total * 1.1, // Ejemplo: Ajuste del total para el segundo gráfico
            ];
        });

        return view('Admin.dashboard', [
            'comprasData1' => $comprasData1,
            'comprasData2' => $comprasData2,
        ]);
    }
}
