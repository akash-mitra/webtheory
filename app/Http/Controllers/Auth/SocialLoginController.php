<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeNewSocialUser;
use App\Parameter;
use App\Traits\CustomEmailSetup;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Socialite;

// use App\Jobs\SendEmail;

class SocialLoginController extends Controller
{
    use CustomEmailSetup;

    protected $providers = ['facebook', 'twitter', 'linkedin', 'google'];


    public function login($provider)
    {
        $this->loadProviderConfig($provider);

        return Socialite::driver($provider)->redirect();
    }


    public function callback($provider)
    {
        $this->loadProviderConfig($provider);

        $socialUser = $this->getSocialUser($provider);

        $this->validateUserInfo($socialUser);

        $existingUser = $this->userExisting($socialUser);

        if ($existingUser) {
            $existingUser->createOrUpdateProvider($provider, $socialUser);

            Auth::login($existingUser, true);
        } else {
            $user = $this->createUserWithProvider($provider, $socialUser);

            Auth::login($user, true);
        }

        return redirect()->route('home', '#');
    }


    private function createUserWithProvider($provider, $socialUser)
    {
        $user = new User([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'role' => 'registered',
            'avatar' => $socialUser->getAvatar(),
            'email_verified_at' => now(),
            'preferences' => ['broadcast', 'database', 'mail'],
            'public_id' => Str::random(30),
        ]);

        $user->save();

        $user->providers()->create([
            'provider_user_id' => $socialUser->getId(),
            'provider'         => $provider,
            'avatar'           => $socialUser->getAvatar()
        ]);

        // SendEmail::dispatch($user->email, new WelcomeNewSocialUser($user));

        $this->sendEmail($user->email, new WelcomeNewSocialUser($user));

        return $user;
    }


    private function getSocialUser($provider)
    {
        try {
            return Socialite::driver($provider)->user();

        } catch (Exception $e) {

            return abort(400, 'Unable to authenticate user');
        }
    }


    private function userExisting($socialUser)
    {
        return User::where('email', $socialUser->getEmail())->first();
    }


    private function validateUserInfo($socialUser)
    {
        if (empty($socialUser->getEmail()) || empty($socialUser->getName()) || empty($socialUser->getAvatar())) {
            abort(406, "Must provide name, email and profile picture");
        }
    }


    private function loadProviderConfig($provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404, 'Provider not supported');
        }

        $redirectUris = json_decode(Parameter::getKey('socialprovider_redirect_url'), true);

        config(['services.' . $provider . '.client_id' => Parameter::getKey(strtoupper($provider). '_CLIENT_ID')]);
        config(['services.' . $provider . '.client_secret' => Parameter::getKey(strtoupper($provider). '_CLIENT_SECRET')]);
        config(['services.' . $provider . '.redirect' => $redirectUris[$provider]]);
    }
}
