<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{public_path('css/pdf.css')}}">
</head>
<body>
    <div>
        <div class="header">
            <h1>Factura de Venta</h1>
        </div>
        <table class="div-1Header">
        <tr>
            <td class="logotd">
                <img src="{{public_path('img/logo.png')}}" alt="logo">
            </td>
            <td class="datos-grales-td">
                <table class="table_h_factura">
                    <tr>
                        <td>
                            <p> 
                                <strong>NIT:</strong> <span>900.123.456-7</span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>TELEFONO:</strong> <span>999-999-9999</span> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Correo:</strong> <span>floristerialatata@gmail.com</span> </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>NUMERO DEL PEDIDO:</strong> <span>4080</span></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>FECHA DEL PEDIDO:</strong> <span>01/04/2024</span></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="linea"></div>

    <!--DATOS-->
    <table class="div-1Datos">
        <tr>
            <td class="receptor">
            <table class="table_receptor">
                <tr>
                    <td class="titulos">
                        <p class="titulos tituloRec">Detalles de envio</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Nombre del destinatario:</strong> <span>Juan Pérez</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Identificacion:</strong> <span>1015431278</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Dirección de Envío:</strong> <span>Calle 123, Ciudad, País</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Instrucciones para la entrega:</strong> <span>Dejar en porteria</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Teléfono de Contacto:</strong> <span>123-456-7890</span></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>Método de pago:</strong> <span>Contra entrega</span></p>
                    </td>
                </tr>
            </table>

            </td>
        </tr>
    </table>

    <div class="linea"></div>


    <!--PRODUCTOS-->
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
            <tr>
                <td>Arreglo 1</td>
                <td>2</td>
                <td>230.000</td>
                <td>460.000</td>
            </tr>
            <tr>
        </tbody>
    </table>

    <!--DATOS FINALES-->
    <table class="div-1Datos">
        <tr>
            <td class="">
                <table class="table_datosFtxt">
                    <tr>
                        <td>
                            <p>¡Gracias por confiar en nosotros! En la Foristeria la tata, nos esforzamos por ofrecer arreglos florales de la mejor y más alta calidad. Esperamos que tu experiencia de compra haya sido satisfactoria y que vuelvas pronto para descubrir más de nuestras ofertas y promociones.</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="datosFinales">
                <table class="table_datosfinales">
                    <tr>
                        <td>
                            <p><strong>Subtotal:</strong></p>
                        </td>
                        <td>
                            <p>$460.000</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>IVA:</strong></p>
                        </td>
                        <td>
                            <p>69.900</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Total:</strong></p>
                        </td>
                        <td>
                            <p>529.000</p>
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