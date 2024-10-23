<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class SendMailsToUsers extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    public $subject;
    public $html;
    public $attachedFile;
    
    /**
     * Create a new message instance.
     */
    public function __construct($name, $subject, $html, $attachedFile = '')
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->html = $html;
        $this->attachedFile = $attachedFile;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            html: $this->html,
            with: ['name' => $this->name]
        );
    }

     /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Only attach the file if a valid path is provided
        if (!empty($this->attachedFile) && file_exists($this->attachedFile)) {
            return [
                Attachment::fromPath($this->attachedFile)->withMime(['application/pdf','image/jpeg','image/png','image/gif','application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel']),
            ];
        }

        return []; // No attachments if the file path is empty or invalid
    }
}
