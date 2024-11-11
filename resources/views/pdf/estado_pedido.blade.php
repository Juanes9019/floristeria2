<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cambio de Estado de Pedido</title>
</head>
<body>
    <p>Hola {{ $pedido->user->name }},</p>

    <p>El estado de tu pedido #{{ $pedido->id }} ha cambiado a {{ $pedido->estado }}.</p>

    @if($pedido->estado === 'no recibido')
        <p>Tu pedido no ha sido recibido, pero se realizará un nuevo envío dentro de los próximos 3 días.</p>
        
        @if($pedido->datos_rechazo)
            @php
                $rechazo = json_decode($pedido->datos_rechazo, true);
            @endphp
            <p><strong>Motivo del rechazo:</strong> {{ $rechazo['motivo'] }}</p>
            <p><strong>Descripción:</strong> {{ $rechazo['descripcion'] }}</p>
        @endif
    @endif

    <p>Si tienes alguna duda, comunicate con nuestro soporte técnico.</p>

    <p>Saludos,<br>
    Floristería</p>
</body>
</html>
