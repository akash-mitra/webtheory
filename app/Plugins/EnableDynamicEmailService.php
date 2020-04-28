<?php

namespace App\Plugins;

use App\Jobs\SendEmail;
use App\Mail\VerifyEmailAddress;
use App\Mail\ResetPasswordLink;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

trait EnableDynamicEmailService {

    /**
     * This method is a override of the originl method present in the
     * Illuminate\Auth\MustVerifyEmail trait. This override has been
     * done to make sure that verify user email is sent via our own
     * emailing Job, instead of laravel's default email job.
     */
    public function sendEmailVerificationNotification()
    {
        // $this->notify(new VerifyEmail);



        SendEmail::dispatch(
            $this->email,
            new VerifyEmailAddress($this)
        );
    }



    /**
     * This method is a override of the originl method present in the
     * Illuminate\Auth\Passwords\CanResetPassword trait. This over-
     * ride has been done to make sure that verify user email is
     * sent via our own emailing Job, instead of laravel's.
     */
    public function sendPasswordResetNotification($token)
    {
        // $this->notify(new ResetPasswordNotification($token));

        SendEmail::dispatch(
            $this->email,
            new ResetPasswordLink($this, $token)
        );
    }


    public function verificationUrl()
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->email),
            ]
        );
    }
}