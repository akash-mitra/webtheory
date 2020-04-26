<?php

namespace App\Mail;

use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLink extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(Storage::disk('active')->exists('ResetPasswordLink.blade.php'))
        {
            return $this->view('active.ResetPasswordLink');
        }

        return $this->view('emails.ResetPasswordLink');
    }
}
