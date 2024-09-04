<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;


class PedidoNotificacion extends Notification
{
    use Queueable;

    protected $pedido;

    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'pedido_id' => $this->pedido->id,
            'mensaje' => 'Un nuevo pedido ha sido realizado.',
            'user_id' => $this->pedido->user_id,
            'url' => url('/admin/pedido'),
        ];
    }    
}
