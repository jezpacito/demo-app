<?php

namespace App\Mail;

use App\Models\UrlShortener;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class EmailSend extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $urlShortened;
    /**
     * Create a new message instance.
     */
    public function __construct(string $urlShortened)
    {
        $this->urlShortened = $urlShortened;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Shortened URL',
            from: new Address('shortened@url.com', 'Shortened URL App'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $trimmedUrl = str_replace("api/", "", str_replace("http://", "", $this->urlShortened));

        return new Content(
            markdown: 'mail.shortened.url',
            with: [
                'url' => $this->urlShortened,
                'trimmedUrl' => $trimmedUrl
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
