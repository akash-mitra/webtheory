<?php

namespace App\Traits;

use App\Parameter;
use ReCaptcha;

trait SpamProtection
{
    public function preventSpamIfCaptchaConfigured($scoreThreshold = 0.5)
    {
        $score = $this->getCaptchaScore();

        if ($score != null) {
            abort_unless($score > $scoreThreshold, 403, 'Suspected Spam');
        }
    }

    private function getCaptchaScore()
    {
        $serviceKey = $this->getCaptchaServiceKey();

        if (empty($serviceKey)) return null;

        $captchaResponse = $this->getCaptchaResponse($serviceKey);

        return $captchaResponse->getScore();
    }

    private function getCaptchaResponse($serviceKey): ReCaptcha\Response
    {
        $request = request();

        $token = $this->findOrFailRecaptchaToken($request);

        $captchaResponse = $this->verifyRecaptcha($serviceKey, $request, $token);

        abort_unless($captchaResponse->isSuccess(), 403, 'Invalid Captcha Response');

        return $captchaResponse;
    }

    private function verifyRecaptcha($serviceKey, $request, $token): ReCaptcha\Response
    {
        $captcha = new ReCaptcha\ReCaptcha($serviceKey->secret_key);

        $captcha->setExpectedHostname($request->getHost());

        return $captcha->verify($token, $request->ip());
    }

    private function findOrFailRecaptchaToken($request)
    {
        $recaptcha_token = $request->input('wt_recaptcha_token');

        abort_if(empty($recaptcha_token), 403, 'No Captcha Token Present');

        return $recaptcha_token;
    }

    private function getCaptchaServiceKey()
    {
        return json_decode(Parameter::getKey('captcha_service'));
    }
}
