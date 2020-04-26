@extends('emails.layout')


@section('body')

    <div style="font-size: 18px; font-weight: bold; padding: 10px 0;">
        Reset Password Notification
    </div>

    <div style="font-size: 14px; padding: 10px 0;">
        <p>
            Hi {{ ucfirst($user->name) }},
        </p>
        <p>
            You are receiving this email because we received a password reset request for your account.
        </p>

        <a href="{{url(route('password.reset', ['token' => $token, 'email' => $user->email], false))}}">Reset Password</a>

        <p>
            This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.

        </p>

        <p>
            If you did not request a password reset, no further action is required.
        </p>

    </div>
@endsection
