<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use App\Parameter;

class DynamicMailServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $mailConfig = [
            'driver'        => Parameter::getKey('MAIL_DRIVER'),
            'host'          => Parameter::getKey('MAIL_HOST'),
            'port'          => Parameter::getKey('MAIL_PORT'),
            'from'          => [
                'address'   => Parameter::getKey('MAIL_FROM_ADDRESS'),
                'name'      => Parameter::getKey('MAIL_FROM_NAME')
            ],
            'encryption'    => Parameter::getKey('MAIL_ENCRYPTION'),
            'username'      => Parameter::getKey('MAIL_USERNAME'),
            'password'      => Parameter::getKey('MAIL_PASSWORD'),
            'sendmail'      => '/usr/sbin/sendmail -bs',
            'pretend'       => false,
        ];
        
        Config::set('mail', $mailConfig);

        $servicesConfig = [
            'mailgun'       => [
                'domain'    => Parameter::getKey('MAILGUN_DOMAIN') == '' ? 'api.mailgun.net' : Parameter::getKey('MAILGUN_DOMAIN'),
                'secret'    => Parameter::getKey('MAILGUN_SECRET'),
                'endpoint'  => Parameter::getKey('MAILGUN_ENDPOINT'),
            ],
        
            'postmark'      => [
                'token'     => Parameter::getKey('POSTMARK_TOKEN'),
            ],
        
            'ses'           => [
                'key'       => Parameter::getKey('AWS_ACCESS_KEY_ID'),
                'secret'    => Parameter::getKey('AWS_SECRET_ACCESS_KEY'),
                'region'    => Parameter::getKey('AWS_DEFAULT_REGION'),
            ],
        ];

        Config::set('services', $servicesConfig);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}