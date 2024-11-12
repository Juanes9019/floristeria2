<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PedidoCambiado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido;

    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        $mail = $this->subject('Cambio de Estado de Pedido')->view('pdf.estado_pedido');

        // Agregar mensaje adicional para el estado 'no recibido'
        if ($this->pedido->estado === 'no recibido') {
            $mail->with([
                'mensaje' => 'Tu pedido no ha sido recibido, pero se realizará un nuevo envío dentro de los próximos 3 días.',
            ]);
        }

        return $mail;
    }
}