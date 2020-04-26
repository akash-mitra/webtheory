@extends('emails.layout')


@section('body')

    <div style="font-size: 18px; font-weight: bold; padding: 10px 0;">
        Verify Email Address
    </div>

    <div style="font-size: 14px; padding: 10px 0;">
        <p>
            Hi {{ ucfirst($user->name) }},
        </p>
        <p>
            In order to complete the registration process, you must verify your email address.
        </p>
        <p>
            Please click on the link below to verify your email address.
        </p>

        <a href="{{ $user->verificationUrl() }}" target="_blank">{{ $user->verificationUrl() }}</a>

        <p>
            If you did not create an account, no further action is required.
        </p>
    </div>
@endsection
