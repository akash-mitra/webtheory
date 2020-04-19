<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Config;
use App\Parameter;

class DynamicMailServiceProvider extends ServiceProvider
{
    protected $driver, $host, $port, $address, $name, $encryption, $username, $password; 
    
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        $this->driver = Cache::get('MAIL_DRIVER');
        $this->host = Cache::get('MAIL_HOST');
        $this->port = Cache::get('MAIL_PORT');
        $this->address = Cache::get('MAIL_FROM_ADDRESS');
        $this->name = Cache::get('MAIL_FROM_NAME');
        $this->encryption = Cache::get('MAIL_ENCRYPTION');
        $this->username = Cache::get('MAIL_USERNAME');
        $this->password = Cache::get('MAIL_PASSWORD');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Log::info(config('mail.driver'));
        \Log::info(cache('MAIL_DRIVER'));
        $mailConfig = [
            'driver'        => $this->driver,
            'host'          => $this->host,
            'port'          => $this->port,
            'from'          => [
                'address'   => $this->address,
                'name'      => $this->name
            ],
            'encryption'    => $this->host,
            'username'      => $this->username,
            'password'      => $this->password,
            'sendmail'      => '/usr/sbin/sendmail -bs',
            'pretend'       => false,
        ];

        \Log::info($this->driver);
        config(['mail.driver' => $this->driver]);
        \Log::info(config('mail.driver'));

        $servicesConfig = [
            // 'mailgun'       => [
            //     'domain'    => Parameter::getKey('MAILGUN_DOMAIN'),
            //     'secret'    => Parameter::getKey('MAILGUN_SECRET'),
            //     'endpoint'  => Parameter::getKey('MAILGUN_ENDPOINT'),
            // ],
        
            // 'postmark'      => [
            //     'token'     => Parameter::getKey('POSTMARK_TOKEN'),
            // ],
        
            // 'ses'           => [
            //     'key'       => Parameter::getKey('AWS_ACCESS_KEY_ID'),
            //     'secret'    => Parameter::getKey('AWS_SECRET_ACCESS_KEY'),
            //     'region'    => Parameter::getKey('AWS_DEFAULT_REGION'),
            // ],
        ];

        Config::set('services', $servicesConfig);
    }
}