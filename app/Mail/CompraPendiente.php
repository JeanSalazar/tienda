<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompraPendiente extends Mailable
{
    use Queueable, SerializesModels;

    public $orden;

    /**
     * Crear una nueva instancia de mensaje.
     *
     * @param  \App\Models\Orden  $orden
     * @return void
     */
    public function __construct($orden)
    {
        $this->orden = $orden;
    }

    /**
     * Construir el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Compra pendiente de revisión de pago')
            ->view('emails.compra_pendiente');
    }
}
