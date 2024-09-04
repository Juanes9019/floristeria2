<!DOCTYPE html>
<html>
<head>
    <title>Lista de Pedidos</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table, .table th, .table td {
            border: 1px solid black;
        }
        .table th, .table td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>PEDIDOS</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Fecha Pedido</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->fechapedido }}</td>
                    <td>{{ $item->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
