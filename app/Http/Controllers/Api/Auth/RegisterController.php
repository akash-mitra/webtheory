<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmail;

class RegisterController extends Controller
{
    /**
     * Register user and account
     *
     * @return \Illuminate\Http\Response
     */
    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => ['required', 'string', 'max:255', 'unique:users'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed']
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'message'=> "The given data was invalid.",
    //             'errors' => $validator->errors()
    //         ], 422);
    //     }

    //     $input = $request->all();
    //     $user = User::create([
    //         'name' => $input['name'],
    //         'email' => $input['email'],
    //         'password' => Hash::make($input['password']),
    //         'role' => 'registered',
    //     ]);

    //     $user->notify(new VerifyEmail());
    //     return response()->json(['message' => 'Please check your email for verification link'], 200);
    // }
}
