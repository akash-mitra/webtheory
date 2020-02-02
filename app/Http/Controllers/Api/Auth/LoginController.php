<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Validator;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 5;

    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */
    protected $decayMinutes = 2;

    /**
     * Login user
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'remember_me' => ['boolean']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> "The given data was invalid.",
                'errors' => $validator->errors()
            ], 422);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            // return $this->sendLockoutResponse($request);
            return response()->json([
                'message'=> "Too many login attempts! Account is locked try after some time",
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json($user, 200);
        } else {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return response()->json(['message' => 'These credentials do not match our records.'], 401);
        }
    }

    /**
     * Logout user
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Successfully logged out.'], 200);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    /**
     * Get the login username to be used by the controller. (Throttle)
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
    
    /**
     * Logged In User
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
