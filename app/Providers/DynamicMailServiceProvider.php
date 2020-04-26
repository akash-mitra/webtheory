<?php

namespace App\Providers;

use Swift_Mailer;
use Swift_SmtpTransport;
use Illuminate\Mail\Mailer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Log;

class DynamicMailServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }



    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        // We define a custom mail service provider and bind the same
        // to the service container under the name 'webtheory.mail'.
        $this->app->bind('webtheory.mail', function ($app, $parameters) {

            $transport = new Swift_SmtpTransport(
                $parameters['host'],
                $parameters['port']
            );

            $transport->setUsername($parameters['username']);
            $transport->setPassword($parameters['password']);
            $transport->setEncryption($parameters['encryption']);

            $swift_mailer = new Swift_Mailer($transport);

            $mailer = new Mailer(
                $app->get('view'),
                $swift_mailer,
                $app->get('events')
            );

            $mailer->alwaysFrom($parameters['username'], $parameters['name']);

            // Log::info($parameters);

            return $mailer;
        });
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['webtheory.mail'];
    }
}