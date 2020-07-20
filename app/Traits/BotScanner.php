<?php

namespace App\Traits;

use App\Parameter;
use ReCaptcha;

trait BotScanner
{
    public function preventBotSubmission($scoreThreshold = 0.5)
    {
        $captchaResponse = $this->getCaptchaResponse();

        $score = $captchaResponse->getScore();

        abort_unless($score > $scoreThreshold, 403, 'Suspected Spam');

        return $score;
    }

    private function getCaptchaResponse()
    {
        $request = request();

        $token = $this->findOrFailRecaptchaToken($request);

        $service = $this->getCaptchaServiceKeys();

        $captchaResponse = $this->verifyRecaptcha($service, $request, $token);

        abort_unless($captchaResponse->isSuccess(), 403, 'Invalid Captcha Response');

        return $captchaResponse;
    }

    private function verifyRecaptcha($service, $request, $token)
    {
        $captcha = new ReCaptcha\ReCaptcha($service->secret_key);

        $captcha->setExpectedHostname($request->getHost());

        return $captcha->verify($token, $request->ip());
    }

    private function findOrFailRecaptchaToken($request)
    {
        $recaptcha_token = $request->input('wt_recaptcha_token');

        abort_if(empty($recaptcha_token), 403, 'No Captcha Token Present');

        return $recaptcha_token;
    }

    private function getCaptchaServiceKeys()
    {
        $service = json_decode(Parameter::getKey('captcha_service'));

        abort_if(empty(optional($service)->secret_key), 403, 'Captcha Service Not Configured');

        return $service;
    }
}
