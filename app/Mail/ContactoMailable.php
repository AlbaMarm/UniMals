<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactoMailable extends Mailable
{
    use Queueable, SerializesModels;

    // Ahora solo necesitamos nombre y body
    public function __construct(
        public string $nombre,
        public string $body
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Usamos la dirección que esté en MAIL_FROM_ADDRESS (y nombre que quieras)
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name')
            ),
            subject: 'Formulario de Contacto'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'vistasemails.vistacontacto'
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
