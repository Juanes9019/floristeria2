<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;

class EstadoPedido extends Notification
{
    use Queueable;

    protected $pedido;

    /**
     * Create a new notification instance.
     *
     * @param $pedido
     * @return void
     */
    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the channels the notification should send on.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; 
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mailMessage = (new MailMessage)
                        ->subject('Cambio de Estado de Pedido')
                        ->line('El estado de tu pedido #' . $this->pedido->id . ' ha cambiado a ' . $this->pedido->estado);

        if ($this->pedido->estado === 'no recibido') {
            $mailMessage->line('Tu pedido no ha sido recibido, pero se realizará un nuevo envío dentro de los próximos 3 días.');
        }

        return $mailMessage;
    }

    public function toDatabase($notifiable)
    {
        $message = 'El estado de tu pedido #' . $this->pedido->id . ' ha cambiado a ' . $this->pedido->estado;
        if ($this->pedido->estado === 'no recibido') {
            $message .= ' - Tu pedido será reenviado en los próximos 3 días.';
        }

        return [
            'pedido_id' => $this->pedido->id,
            'mensaje' => $message,
        ];
    }
}
