<?php

namespace App\Exports;

use App\Models\Pedido;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PedidoExport implements FromView, ShouldAutoSize, WithStyles
{
    use Exportable;

    /**
     * Define la vista para la exportación.
     *
     * @return View
     */
    public function view(): View
    {
        return view('exports.pedidos', [
            'pedidos' => Pedido::all() // Aquí obtienes todos los pedidos
        ]);
    }

    /**
     * Define los estilos de la hoja de cálculo.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            '1' => ['font' => ['bold' => true]], 
        ];
    }
}
