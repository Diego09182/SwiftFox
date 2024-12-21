<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        // No need for token or any other data
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Simple Test Email')
                    ->view('emails.test');
    }
}
