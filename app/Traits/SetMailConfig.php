<?php

namespace App\Traits;

use App\Parameter;
use Illuminate\Mail\Mailable;
use App\Jobs\SendEmail;
use Illuminate\Support\Facades\Mail;

trait SetMailConfig
{
    public function sendEmail(string $to, Mailable $mailable)
    {
        $mailDriver = Parameter::getKey('MAIL_DRIVER');

        if ($mailDriver != '') {
            try {
                if ($mailDriver == 'smtp') {
                    SendEmail::dispatch($to, $mailable);
                } else {
                    config(['mail.default' => Parameter::getKey('MAIL_DRIVER')]);
                    config(['mail.from.address' => Parameter::getKey('MAIL_FROM_ADDRESS')]);
                    config(['mail.from.name' => Parameter::getKey('MAIL_FROM_NAME')]);

                    if ($mailDriver == 'ses') {
                        config(['mail.mailers.ses.key' => Parameter::getKey('AWS_ACCESS_KEY_ID')]);
                        config([
                            'mail.mailers.ses.secret' => Parameter::getKey('AWS_SECRET_ACCESS_KEY'),
                        ]);
                        config([
                            'mail.mailers.ses.region' => Parameter::getKey('AWS_DEFAULT_REGION'),
                        ]);
                    } elseif ($mailDriver == 'mailgun') {
                        config([
                            'mail.mailers.mailgun.domain' => Parameter::getKey('MAILGUN_DOMAIN'),
                        ]);
                        config([
                            'mail.mailers.mailgun.secret' => Parameter::getKey('MAILGUN_SECRET'),
                        ]);
                    } elseif ($mailDriver == 'postmark') {
                        config([
                            'mail.mailers.postmark.token' => Parameter::getKey('POSTMARK_TOKEN'),
                        ]);
                    }

                    Mail::to($to)->send($mailable);
                }

                return response()->json('Mail Sent', 200);
            } catch (Exception $e) {
                return abort(400, $e);
            }
        }

        return response()->json('Mail Driver not set', 400);
    }
}
