<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
</head>
<body>
    <h2>¡Gracias por tu compra!</h2>
    <p>El pedido #<strong>{{ $pedido->id }}</strong> se generó con éxito.</p>
    <p>Cuando se realice el pago, el estado del envío cambiará a "Preparación".</p>
    <p>Te invitamos a estar pendiente del estado de tu pedido a través de tu cuenta en nuestra tienda.</p>
    <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
</body>
</html>
