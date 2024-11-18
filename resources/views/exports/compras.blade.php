<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Fecha</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Proveedor</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Costo Total</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($compras as $compra)
        <tr>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $compra->created_at->format('d/m/Y H:i') }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $compra->proveedor->nombre }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">${{ number_format($compra->costo_total, 0, ',', '.') }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $compra->estado }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        margin: 20px 0;
    }

    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    thead th {
        background-color: #f8ccd6; 
        text-align: center;
        font-weight: bold;
        padding: 10px;
    }

    tbody tr:nth-child(even) {
        background-color: #f8ccd6; 
    }

    tbody td {
        text-align: center;
        padding: 10px;
    }
</style>
