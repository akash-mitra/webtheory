@extends('layouts.app')

@section('content')
<div class="container mx-auto h-full flex justify-center items-center">
    <div class="row justify-content-center">
        <div class="max-w-md mx-auto w-full bg-white border rounded-lg p-8 shadow-2xl">
            <div class="text-blue-500 font-semibold py-2">{{ __('Login') }}</div>
            <div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex flex-col mb-4">
                        <label for="email" class="text-xs py-2 text-gray-700">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="px-2 py-1 w-full border bg-gray-200 rounded" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="text-xs text-red-600 email" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex flex-col mb-4">
                        <label for="password" class="text-xs py-2 text-gray-700">{{ __('Password') }}</label>
                        <input id="password" type="password" class="px-2 py-1 w-full border bg-gray-200 rounded" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="text-xs text-red-600 password" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex">
                        <div>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>
                        <div class="flex flex-col">
                            <label class="text-xs text-gray-700 ml-3" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row lg:justify-between mt-4">
                        <div class="self-center mr-2">
                            <button
                                type="submit"
                                id="submit_button"
                                class="bg-transparent hover:bg-indigo-500 text-indigo-700 text-sm font-semibold hover:text-white py-2 px-4 border border-indigo-500 hover:border-transparent rounded"
                                >
                                {{ __('Login') }}
                            </button>
                        </div>
                        <div class="self-center mt-2 lg:mt-0">
                            <a class="text-sm text-gray-700 hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
