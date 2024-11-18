<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Fecha</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Insumo</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($perdidas as $perdida)
        <tr>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $perdida->fecha_perdida }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $perdida->insumo->nombre }}{{ $perdida->insumo->color ? ' - ' . $perdida->insumo->color : '' }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $perdida->cantidad_perdida }}</td>
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
