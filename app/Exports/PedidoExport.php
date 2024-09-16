<?php

namespace App\Exports;

use App\Models\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PedidoExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pedido::select('id', 'total', 'fechapedido', 'estado', 'user_id')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Total',
            'Fecha del Pedido',
            'Estado',
            'ID del Usuario',
        ];
    }
}
