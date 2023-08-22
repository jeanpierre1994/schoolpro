<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Groupepedagogiques;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReleveNotes extends Mailable
{
    use Queueable, SerializesModels;

    public $etudiant;
    public $gp;
    public $examen;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($etudiant, $examen)
    {
        $this->etudiant = $etudiant;
        $this->examen = $examen;
        $this->gp = Groupepedagogiques::where('id', $this->etudiant->groupepedagogique_id);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'SchoolPro : Releve Notes',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.releveNotes',
            with: [
                'etudiant' => $this->etudiant,
                'examen' => $this->examen,
                'gp' => $this->gp,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
