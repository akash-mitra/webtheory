<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Cache;
use App\Http\Requests\SecretRequest;
use App\Template;
use App\Parameter;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Login customization code written by Akash
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->google2fa_secret) {
            Auth::logout();

            $request->session()->put('2fa:user:id', $user->id);

            return redirect('google2fa/validate');
        }

        return back();
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function getToken()
    {
        if (session('2fa:user:id')) {

            $template = Cache::rememberForever('template.parameters', function () {
                $param = optional(Template::where('active', 1)->first())->parameters;
    
                $array = (array)json_decode($param, true);
    
                return (object)array_column($array, 'value', 'name');
            });
            return view('google2fa/validate', [
                'template' => $template,
                'site' => json_decode(Parameter::getKey('siteinfo'))
            ]);
        }

        return back();
    }

    /**
     *
     * @param  App\Http\Requests\SecretRequest $request
     * @return \Illuminate\Http\Response
     */
    public function validateToken(SecretRequest $request)
    {
        // get user id and create cache key
        $userId = $request->session()->pull('2fa:user:id');
        $key    = $userId . ':' . $request->totp;

        // use cache to store token to blacklist
        Cache::add($key, true, 4);

        // login and redirect user
        Auth::loginUsingId($userId);

        return back();
    }
}
