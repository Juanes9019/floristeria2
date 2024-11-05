<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Usuario</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Total</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Fecha_pedido</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">comprobante_url</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $item)
        <tr>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $item->user_id }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $item->total }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center; color: #0000FF">{{ $item->fechapedido }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $item->comprobante_url }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $item->estado }}</td>
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
