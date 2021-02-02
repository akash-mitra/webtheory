<?php

namespace App\Listeners;

// use App\Jobs\SendEmail;
use App\Mail\WelcomeNewUser;
use App\Traits\CustomEmailSetup;
use Illuminate\Auth\Events\Verified;

class UserEmailVerified
{
    use CustomEmailSetup;

    /**
     * Handle the Email Verified event.
     *
     */
    public function handle(Verified $event)
    {
        $user = $event->user;

        // SendEmail::dispatch($user->email, new WelcomeNewUser($user));

        $this->sendEmail($user->email, new WelcomeNewUser($user));
    }
}
