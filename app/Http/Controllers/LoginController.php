<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;

class LoginController extends Controller
{
    /**
     * Login user and create token
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
            
            $tokenResult = $user->createToken($user->email.'-'.now()->format('YmdHis'));
            $token = $tokenResult->token;
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
            $token->save();

            $user->token_type = 'Bearer';
            $user->access_token = $tokenResult->accessToken;
            $user->expires_at = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'These credentials do not match our records.'], 401);
        }
    }

    /**
     * Logout user and revoke token
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $userTokens =  Auth::user()->tokens;
        foreach ($userTokens as $token) {
            $token->revoke();
        }
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
