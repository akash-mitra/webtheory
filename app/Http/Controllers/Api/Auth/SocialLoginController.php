<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Parameter;

class SocialLoginController extends Controller
{
    /**
     * list of social drivers enabled for Social Auth
     */
    protected $providers = ['facebook', 'twitter', 'linkedin', 'google'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $provider_redirect_urls = json_decode(Parameter::getKey('provider_redirect_urls'), true);

        config(['services.facebook.client_id' => Parameter::getKey('FACEBOOK_CLIENT_ID')]);
        config(['services.facebook.client_secret' => Parameter::getKey('FACEBOOK_CLIENT_SECRET')]);
        config(['services.facebook.redirect' => $provider_redirect_urls['facebook']]);

        config(['services.twitter.client_id' => Parameter::getKey('TWITTER_CLIENT_ID')]);
        config(['services.twitter.client_secret' => Parameter::getKey('TWITTER_CLIENT_SECRET')]);
        config(['services.twitter.redirect' => $provider_redirect_urls['twitter']]);

        config(['services.linkedin.client_id' => Parameter::getKey('LINKEDIN_CLIENT_ID')]);
        config(['services.linkedin.client_secret' => Parameter::getKey('LINKEDIN_CLIENT_SECRET')]);
        config(['services.linkedin.redirect' => $provider_redirect_urls['linkedin']]);

        config(['services.google.client_id' => Parameter::getKey('GOOGLE_CLIENT_ID')]);
        config(['services.google.client_secret' => Parameter::getKey('GOOGLE_CLIENT_SECRET')]);
        config(['services.google.redirect' => $provider_redirect_urls['google']]);
    }

    public function socialProviders()
    {
        $value = Parameter::getKey('providers');
        return response()->json($value);
    }

    public function login($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return response()->json(['message' => 'Provider not supported'], 404);
        }

        if ($provider == 'twitter')
            return ['url' => Socialite::driver($provider)->redirect()->getTargetUrl()];
        else
            return ['url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()];
    }


    public function callback($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return response()->json(['message' => 'Provider not supported'], 404);
        }

        $authenticatedUser = $this->getAuthenticatedUser($provider);
        $this->abortIfInfoMissing($authenticatedUser);
        $user = $this->authenticatedUserExisting($authenticatedUser);

        if ($user) {
            $user->createOrUpdateProvider($provider, $authenticatedUser);
            Auth::login($user, true);
        } else {
            $user = $this->createUserWithProvider($provider, $authenticatedUser);
            Auth::login($user, true);
            // return response()->json(['message' => 'User does not exist in our system'], 404);
        }

        return response()->json($user, 200);
    }


    private function createUserWithProvider($provider, $authenticatedUser)
    {
        $user = new User([
            'name' => $authenticatedUser->getName(),
            'email' => $authenticatedUser->getEmail(),
            'role' => 'admin',
            'avatar' => $authenticatedUser->getAvatar(),
            'email_verified_at' => now()
        ]);

        $user->save();

        $user->providers()->create([
            'provider_user_id' => $authenticatedUser->getId(),
            'provider'         => $provider,
            'avatar'           => $authenticatedUser->getAvatar()
        ]);
        
        return $user;
    }

    private function getAuthenticatedUser($provider)
    {
        try {
            if ($provider == 'twitter')
                return Socialite::driver($provider)->user();
            else
                return Socialite::driver($provider)->stateless()->user();
        } catch (Exception $e) {
            return response()->json(['message' => 'Unable to authenticate user'], 400);
        }
    }


    private function authenticatedUserExisting($authenticatedUser)
    {
        return User::where('email', $authenticatedUser->getEmail())->first();
    }


    /**
     * Checks the authenticated user returned from the
     * social provider to make sure all the mandatory
     * information are present
     *
     * @param  object $authenticatedUser
     * @return void
     */
    private function abortIfInfoMissing($authenticatedUser)
    {
        if (empty($authenticatedUser->getEmail())
            || empty($authenticatedUser->getName())
            || empty($authenticatedUser->getAvatar())) {
                return response()->json(['message' => 'Must provide name, email and profile picture'], 406);
        }
    }
}
