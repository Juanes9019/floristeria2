<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cambio de Estado de Pedido</title>
</head>
<body>
    <p>Hola {{ $pedido->user->name }},</p>

    <p>El estado de tu pedido #{{ $pedido->id }} ha cambiado a {{ $pedido->estado }}.</p>
    <p>Si tienes alguna duda, comunicate con nuestro soporte tecnico</p>

    <p>Saludos,<br>
    Floristeria</p>
</body>
</html>
