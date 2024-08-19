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
    <h1>DETALLE DE PEDIDOS</h1>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>id_pedido</th>
                <th>id_producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalle as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->id_pedido }}</td>
                    <td>{{ $item->id_producto }}</td>
                    <td>{{ number_format($item->precio, 0, ',', '.') }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
