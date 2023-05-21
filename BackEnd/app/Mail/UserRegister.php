<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\URL;

class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    private $data;
    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->data = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Register',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.userRegister',
            with: [
                'data' => $this->data,
            ],
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     $verification_url = $this->getVerificationUrl();
        
    //     return $this->markdown('emails.userRegister', [
    //         'verification_url' => $verification_url
    //     ]);
    // }

    // /**
    //  * Get the verification URL for the user.
    //  *
    //  * @return string
    //  */
    // protected function getVerificationUrl()
    // {
    //     return URL::signedRoute('verification.verify', [
    //         'id' => $this->data->getKey(),
    //         'hash' => sha1($this->data->getEmailForVerification())
    //     ]);
    // }

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
