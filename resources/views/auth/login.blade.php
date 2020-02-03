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

                    <div
                        class="flex flex-row justify-center font-semibold py-3 px-6 border rounded-sm border-indigo-200 bg-indigo-100 mt-4"
                    >
                        <a
                            href="{{ route('social.login', ['provider' => 'twitter']) }}"
                            class="mr-4 twitter"
                            title="Twitter"
                            >
                            <svg
                                class="text-gray-600 hover:text-indigo-500 text-3xl"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                width="34"
                                height="34"
                                >
                                <path
                                    class="fill-current"
                                    d="M18.258,3.266c-0.693,0.405-1.46,0.698-2.277,0.857c-0.653-0.686-1.586-1.115-2.618-1.115c-1.98,0-3.586,1.581-3.586,3.53c0,0.276,0.031,0.545,0.092,0.805C6.888,7.195,4.245,5.79,2.476,3.654C2.167,4.176,1.99,4.781,1.99,5.429c0,1.224,0.633,2.305,1.596,2.938C2.999,8.349,2.445,8.19,1.961,7.925C1.96,7.94,1.96,7.954,1.96,7.97c0,1.71,1.237,3.138,2.877,3.462c-0.301,0.08-0.617,0.123-0.945,0.123c-0.23,0-0.456-0.021-0.674-0.062c0.456,1.402,1.781,2.422,3.35,2.451c-1.228,0.947-2.773,1.512-4.454,1.512c-0.291,0-0.575-0.016-0.855-0.049c1.588,1,3.473,1.586,5.498,1.586c6.598,0,10.205-5.379,10.205-10.045c0-0.153-0.003-0.305-0.01-0.456c0.7-0.499,1.308-1.12,1.789-1.827c-0.644,0.28-1.334,0.469-2.06,0.555C17.422,4.782,17.99,4.091,18.258,3.266"
                                />
                            </svg>
                        </a>
                        <a
                            href="{{ route('social.login', ['provider' => 'facebook']) }}"
                            class="mr-4 facebook"
                            title="Facebook"
                            >
                            <svg
                                class="text-gray-600 hover:text-indigo-500 text-3xl"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                width="34"
                                height="34"
                                >
                                <path
                                    class="fill-current"
                                    d="M11.344,5.71c0-0.73,0.074-1.122,1.199-1.122h1.502V1.871h-2.404c-2.886,0-3.903,1.36-3.903,3.646v1.765h-1.8V10h1.8v8.128h3.601V10h2.403l0.32-2.718h-2.724L11.344,5.71z"
                                />
                            </svg>
                        </a>
                        <a
                            href="{{ route('social.login', ['provider' => 'instagram']) }}"
                            class="mr-4 instagram"
                            title="Instagram"
                            >
                            <svg
                                class="text-gray-600 hover:text-indigo-500 text-3xl"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                width="34"
                                height="34"
                                >
                                <path
                                    class="fill-current"
                                    d="M14.52,2.469H5.482c-1.664,0-3.013,1.349-3.013,3.013v9.038c0,1.662,1.349,3.012,3.013,3.012h9.038c1.662,0,3.012-1.35,3.012-3.012V5.482C17.531,3.818,16.182,2.469,14.52,2.469 M13.012,4.729h2.26v2.259h-2.26V4.729z M10,6.988c1.664,0,3.012,1.349,3.012,3.012c0,1.664-1.348,3.013-3.012,3.013c-1.664,0-3.012-1.349-3.012-3.013C6.988,8.336,8.336,6.988,10,6.988 M16.025,14.52c0,0.831-0.676,1.506-1.506,1.506H5.482c-0.831,0-1.507-0.675-1.507-1.506V9.247h1.583C5.516,9.494,5.482,9.743,5.482,10c0,2.497,2.023,4.52,4.518,4.52c2.494,0,4.52-2.022,4.52-4.52c0-0.257-0.035-0.506-0.076-0.753h1.582V14.52z"
                                />
                            </svg>
                        </a>
                        <a
                            href="{{ route('social.login', ['provider' => 'google']) }}"
                            class="mr-4 google"
                            title="Google"
                            >
                            <svg
                                class="text-gray-600 hover:text-indigo-500 text-3xl"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                width="34"
                                height="34"
                                >
                                <path
                                    class="fill-current"
                                    d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z"
                                />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
