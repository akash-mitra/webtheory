<?php

namespace App\Jobs;

use App\Parameter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

/**
 * This is a generic Email Queue for the application.
 * This email queue allows us to use the custom
 * SMTP configuration parameters as needed.
 */
class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $to;
    public $mailable;
    public $parameters;

    /**
     * Create a new SendMail job instance.
     *
     * @return void
     */
    public function __construct(string $to, Mailable $mailable)
    {
        $this->to = $to;
        $this->mailable = $mailable;
        $this->parameters = $this->getMailTransportParameters();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Obtain an instance of DynamicMailServiceProvider
        $mailServiceProvider = app()->makeWith('webtheory.mail', $this->parameters);

        // send the mail via this mail service provider
        $mailServiceProvider->to($this->to)->send($this->mailable);
    }

    /**
     * Validate all necessary parameters for emailing are present.
     * Some of the parameters can be enriched with default values
     * even if the parameter values are missing.
     */
    private function getMailTransportParameters()
    {
        $parameters = [
            'driver' => Parameter::getKey('MAIL_DRIVER'),
            'host' => Parameter::getKey('MAIL_HOST'),
            'port' => Parameter::getKey('MAIL_PORT'),
            'email' => Parameter::getKey('MAIL_FROM_ADDRESS'),
            'name' => Parameter::getKey('MAIL_FROM_NAME'),
            'username' => Parameter::getKey('MAIL_USERNAME'),
            'password' => Parameter::getKey('MAIL_PASSWORD'),
            'encryption' => Parameter::getKey('MAIL_ENCRYPTION'),
        ];

        return $parameters;
    }
}
