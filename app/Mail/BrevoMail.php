<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use App\Models\Campagna;
use App\Models\Invio;
use App\Models\LogInvio;

class BrevoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campagna;
    public $invioCampagna;
    public $logInvio;

    // Riceviamo tutti e tre gli oggetti
    public function __construct(Campagna $campagna, Invio $invio, LogInvio $logInvio)
    {
        $this->campagna = $campagna;
        $this->invioCampagna = $invioCampagna;
        $this->logInvio = $logInvio;
    }

    //Definisco i metadati dell'email
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->invioCampagna->oggetto,
            from: $this->invioCampagna->email_mittente,
            replyTo: $this->invioCampagna->email_risposta ? [$this->invioCampagna->email_risposta] : [],
        );
    }

    //Intestazione personalizzata dove passo l'id del log d'invio, così che quando mi torna
    //il webhook ho il riferimento diretto dove salvarlo
    public function headers(): Headers
    {
        return new Headers(
            text: [
                'X-Mailin-custom' => (string) $this->logInvio->id,
            ],
        );
    }

    //Corpo della mail
    public function content(): Content
    {
        return new Content(
            view: 'email.emailCampagna',
        );
    }
}