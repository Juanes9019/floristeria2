<table>
    <thead>
        <tr>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">No</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Nombre</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Teléfono</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Correo</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Ubicación</th>
            <th style="border: 1px solid black; background-color: #f8ccd6; padding: 10px; text-align: center; font-weight: bold;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proveedores as $proveedor)
        <tr>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $loop->iteration }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $proveedor->nombre }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $proveedor->telefono }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center; color: #0000FF">{{ $proveedor->correo }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $proveedor->ubicacion }}</td>
            <td style="border: 1px solid black; padding: 10px; text-align: center;">{{ $proveedor->estado == 1 ? 'Activo' : 'Inactivo' }}</td>
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
