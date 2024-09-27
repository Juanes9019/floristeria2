<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Categoria_insumo</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Nombre</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Cantidad Insumo</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Costo Unitario</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Perdida Insumo</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Costo Perdida	</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($insumos as $insumo)
        <tr>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $insumo->categoria_insumo->nombre }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $insumo->nombre }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $insumo->cantidad_insumo }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ number_format($insumo->costo_unitario, 0, ',', '.') }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $insumo->perdida_insumo }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ number_format($insumo->costo_perdida, 0, ',', '.') }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $insumo->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
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
