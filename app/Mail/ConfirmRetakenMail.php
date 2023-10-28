<?php

namespace App\Mail;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConfirmRetakenMail extends Mailable
{
    use Queueable, SerializesModels;
    public $retakenEnrollment;
    /**
     * Create a new message instance.
     */
    public function __construct(Enrollment $retakenEnrollment)
    {
        $this->retakenEnrollment = $retakenEnrollment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirm Retaken Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.confirm_retaken',
            with: [
                "retakenEnrollment"=>$this->retakenEnrollment
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
