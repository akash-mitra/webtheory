<?php


namespace App\DataProviders\Common;


use App\Parameter;

class LoginDataProvider
{
    private array $loginProviders;

    public function __construct()
    {
        $this->loginProviders = json_decode(Parameter::getKey('socialprovider'), true);
    }

    public function canUse($platform): bool
    {
        return $this->loginProviders[$platform] !== 'Off';
    }

}
