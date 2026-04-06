<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $name,
        public string $code,
        public string $type
    ) {}

    /**
     * Get the message envelope.
     */
   public function envelope(): Envelope
    {
        $subjects = [
            'register' => __('messages.otp_subject_register'),
            'reset_password' => __('messages.otp_subject_reset_password'),
            'resend' => __('messages.otp_subject_resend'),
        ];

        return new Envelope(
            subject: $subjects[$this->type] ?? __('messages.otp_subject_register'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.otp',
        );
    }
}
