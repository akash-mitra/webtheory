<?php

namespace App\Mail;

use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Parameter;

class WelcomeNewSocialUser extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $site;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->site = json_decode(Parameter::getKey('siteinfo'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Welcome ' . ucfirst($this->user->name));

        if (Storage::disk('active')->exists('WelcomeNewSocialUser.blade.php')) {
            return $this->view('active.WelcomeNewSocialUser');
        }

        return $this->view('emails.WelcomeNewSocialUser');
    }
}
