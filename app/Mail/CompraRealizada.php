<?php

namespace App\Mail;

use App\Models\Orden;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompraRealizada extends Mailable
{
    use Queueable, SerializesModels;

  
    public $orden;

    public function __construct(Orden $orden)
    {
        $this->orden = $orden;
    }


    public function build()
    {
        return $this->view('emails.compra')
                    ->subject('Detalles de tu compra en Nanotech Store');
    }
    
  
}
