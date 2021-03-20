<?php

namespace App\Traits;

use App\Jobs\SendEmail;
use App\Parameter;
use Illuminate\Http\JsonResponse;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

/**
 * Trait CustomEmailSetup
 * Provides the ability to send email using a custom email configuration.
 *
 * @package App\Traits
 */
trait CustomEmailSetup
{
    /**
     * Send email using the custom email configuration.
     *
     * @param string $to
     * @param Mailable $mailable
     * @return JsonResponse
     */
    public function sendEmail(string $to, Mailable $mailable): JsonResponse
    {
        $mailDriver = Parameter::getKey('MAIL_DRIVER');

        if (empty($mailDriver)) {
            return response()->json('Mail Driver not set', 400);
        }

        if ($mailDriver == 'smtp') {
            SendEmail::dispatch($to, $mailable);
        } else {
            config([
                'mail.default' => Parameter::getKey('MAIL_DRIVER'),
                'mail.from.address' => Parameter::getKey('MAIL_FROM_ADDRESS'),
                'mail.from.name' => Parameter::getKey('MAIL_FROM_NAME')
            ]);

            switch ($mailDriver) {
                case 'ses':
                    config([
                        'mail.mailers.ses.key' => Parameter::getKey('AWS_ACCESS_KEY_ID'),
                        'mail.mailers.ses.secret' => Parameter::getKey('AWS_SECRET_ACCESS_KEY'),
                        'mail.mailers.ses.region' => Parameter::getKey('AWS_DEFAULT_REGION'),
                    ]);
                    break;

                case 'mailgun':
                    config([
                        'mail.mailers.mailgun.domain' => Parameter::getKey('MAILGUN_DOMAIN'),
                        'mail.mailers.mailgun.secret' => Parameter::getKey('MAILGUN_SECRET'),
                    ]);
                    break;

                case 'postmark':
                    config([
                        'mail.mailers.postmark.token' => Parameter::getKey('POSTMARK_TOKEN'),
                    ]);
                    break;
            }

            Mail::to($to)->send($mailable);
        }

        return response()->json('Mail Sent');
    }
}
