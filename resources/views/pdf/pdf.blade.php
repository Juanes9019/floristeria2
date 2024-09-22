<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Venta</title>
    <link rel="stylesheet" href="{{ public_path('css/pdf.css') }}">
</head>
<body>
    <div>
        <div class="header">
            <h1>Factura de Venta</h1>
        </div>
        <table class="div-1Header">
            <tr>
                <td class="logotd">
                    <img src="{{ public_path('img/logo.png') }}" alt="logo">
                </td>
                <td class="datos-grales-td">
                    <table class="table_h_factura">
                        <tr>
                            <td>
                                <p><strong>NIT:</strong> <span>900.123.456-7</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>TELÉFONO:</strong> <span>999-999-9999</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Correo:</strong> <span>floristerialatata@gmail.com</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>NÚMERO DEL PEDIDO:</strong> <span>{{ $pedido->id }}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>FECHA DEL PEDIDO:</strong> <span>{{ $pedido->fechapedido->format('d/m/Y') }}</span></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="linea"></div>

        <!-- DATOS DE ENVÍO -->
        <table class="div-1Datos">
            <tr>
                <td class="receptor">
                    <table class="table_receptor">
                        <tr>
                            <td class="titulos">
                                <p class="titulos tituloRec">Detalles de Envío</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Nombre del destinatario:</strong> <span>{{ $datosEnvio['nombre_destinatario'] }}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Dirección de Envío:</strong> <span>{{ $datosEnvio['direccion'] }}, {{ $datosEnvio['ciudad'] }}, {{ $datosEnvio['departamento'] }}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Instrucciones para la entrega:</strong> <span>{{ $datosEnvio['instrucciones_entrega'] }}</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p><strong>Teléfono de Contacto:</strong> <span>{{ $datosEnvio['telefono'] }}</span></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="linea"></div>

        <!-- PRODUCTOS -->
        <table class="table_materiales">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->detalles as $detalle)
                    @if ($detalle->id_producto === null)
                        <!-- Arreglo personalizado -->
                        <tr>
                            <td>Arreglo Personalizado</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio, 0, ',', '.') }}</td>
                            <td>${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                        </tr>

                        <!-- Verificar si 'opciones' no es nulo y contiene 'items' -->
                        @if($detalle->opciones && json_decode($detalle->opciones)->items)
                            @foreach (json_decode($detalle->opciones)->items as $item)
                                <tr>
                                    <td>- {{ $item->name }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>${{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>${{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif

                    @else
                        <!-- Producto estándar -->
                        <tr>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio, 0, ',', '.') }}</td>
                            <td>${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <!-- DATOS FINALES -->
        <table class="div-1Datos">
            <tr>
                <td class="">
                    <table class="table_datosFtxt">
                        <tr>
                            <td>
                                <p>¡Gracias por confiar en nosotros! En la Floristería La Tata, nos esforzamos por ofrecer arreglos florales de la mejor calidad. Esperamos que tu experiencia de compra haya sido satisfactoria y que vuelvas pronto para descubrir más ofertas y promociones.</p>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="datosFinales">
                    <table class="table_datosfinales">
                        <tr>
                            <td>
                                <p><strong>Total:</strong></p>
                            </td>
                            <td>
                                <p>${{ number_format($pedido->total, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div class="footer">
            <h1 class="pie">¡Gracias por tu compra!</h1>
        </div>
    </body>
</html>
