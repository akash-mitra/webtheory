<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;

class SocialLoginController extends Controller
{
    /**
     * list of social drivers enabled for Social Auth
     */
    protected $providers = ['twitter', 'facebook', 'instagram', 'google'];

    public function login($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return response()->json(['message' => 'Provider not supported'], 404);
        }
        
        return ['url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()];
    }


    public function callback($provider)
    {
        if (!in_array($provider, $this->providers)) {
            return response()->json(['message' => 'Provider not supported'], 404);
        }

        $authenticatedUser = $this->getAuthenticatedUser($provider);
        $this->abortIfInfoMissing($authenticatedUser);
        $existingUser = $this->authenticatedUserExisting($authenticatedUser);

        if ($existingUser) {
            $existingUser->createOrUpdateProvider($provider, $authenticatedUser);
            Auth::login($existingUser, true);
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
            'role' => 'registered',
            'avatar' => $authenticatedUser->getAvatar(),
            'email_verified_at' => \Carbon\Carbon::now()
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
