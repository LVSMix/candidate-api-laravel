<?php

namespace App\Mail;

use App\Models\Cliente;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Cotizacion extends Mailable
{
    use Queueable, SerializesModels;

    public $cliente;

    /**
     * Create a new message instance.
     */

      // return void;

     public function __construct(Cliente $cliente)
    {
        $this->cliente=$cliente;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cliente = $this->cliente;
        return $this->subject("Cotizacion")
                    ->from(env('MAIL_FROM_ADDRESS'))
                    ->view('mails.Cotizacion',compact('cliente'));
    }
}
