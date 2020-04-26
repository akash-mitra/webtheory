@extends('layouts.app')

@section('content')

<div style="width: 100%; height: 100vh; display:flex; justify-content: center; align-items: center; background-color: #ebf8ff">
    <div style="width: 100%; max-width: 560px; padding: 30px; background-color: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);">


                <div style="display: block; font-size: 24px; padding-bottom: 20px; border-bottom: 1px solid #ccc">{{ __('Reset Password') }}</div>

                <div style="padding-top: 30px">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" style="font-size: 18px;">{{ __('E-Mail Address') }}</label>

                            <div style="padding-top: 5px; padding-bottom: 20px; overflow: hidden">
                                <input id="email" type="email" style="width: 100%; padding: 10px; font-size: 16px; background-color: #ebf8ff; border: none; @error('email') color: red @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" style="font-size: 18px;">
                                {{ __('New Password') }}
                                <span style="color: #444; font-size: 14px; margin-left: 20px;">(Minimum 8 characters)</span>
                            </label>

                            <div style="padding-top: 5px; padding-bottom: 20px; overflow: hidden">
                                <input id="password" type="password" style="width: 100%; padding: 10px; font-size: 16px; background-color: #ebf8ff; border: none;" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span style="color: red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" style="font-size: 18px;">{{ __('Confirm New Password') }}</label>

                            <div style="padding-top: 5px; padding-bottom: 20px; overflow: hidden">
                                <input id="password-confirm" type="password" style="width: 100%; padding: 10px; font-size: 16px; background-color: #ebf8ff; border: none" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div style="margin-top: 10px; width: 100%;">

                                <button type="submit" style="width: 100%; cursor:pointer; background-color: #4299e1; color: white; padding: 10px 20px; border: none; font-size: 18px">
                                    {{ __('Reset Password') }}
                                </button>

                        </div>
                    </form>
                </div>

    </div>
</div>
@endsection
