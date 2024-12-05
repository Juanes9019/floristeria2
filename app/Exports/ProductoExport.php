<?php

namespace App\Exports;

use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductoExport implements FromView, ShouldAutoSize,WithStyles
{
    use Exportable;
    
    public function view(): View
    {
        return view('exports.productos', [
            'productos' => Producto::all()
        ]);
    }

    
     public function styles(Worksheet $sheet){
        return [
            '1' => ['font' => ['bold' => TRUE]]
        ];
        $sheet->getStyle('1')->getFont('bold')->setBold(true);
     }
}


