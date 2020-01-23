<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class LoginController extends Controller
{
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json($user, 200);
        } else {
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
