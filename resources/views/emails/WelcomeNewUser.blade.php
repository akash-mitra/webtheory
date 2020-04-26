@extends('emails.layout')


@section('body')

<div style="font-size: 18px; font-weight: bold; padding: 10px 0;">
    Welcome {{ ucfirst($user->name) }}
</div>

<div style="padding: 10px 0; font-size: 14px;">
    <p>
        Thanks for verifying your email address.
    </p>

    <p>
        You now have unrestricted access to our blog.
        Please don't forget to keep your account profile updated.
    </p>

    <p>
        Happy Browsing!
    </p>
</div>

<div style="padding: 10px 0; border-top: 1px solid #ccc;">
    <small style="font-size: 12px; color: gray">
        You are getting this email as you signed up to
        our website using the email id {{ $user->email }}.
    </small>
</div>

@endsection