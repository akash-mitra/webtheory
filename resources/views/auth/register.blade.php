@extends('layouts.app')

@section('content')
<div class="container mx-auto h-full flex justify-center items-center">
    <div class="row justify-content-center">
        <div class="max-w-md mx-auto w-full bg-white border rounded-lg p-8 shadow-2xl">
            <div class="text-blue-500 font-semibold py-2">{{ __('Register') }}</div>
            <div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="flex flex-col mb-4">
                        <label for="name" class="text-xs py-2 text-gray-700">{{ __('Name') }}</label>
                        <input id="name" type="text" class="px-2 py-1 w-full border bg-gray-200 rounded" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="text-xs text-red-600 name" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

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
                        <input id="password" type="password" class="px-2 py-1 w-full border bg-gray-200 rounded" name="password" required autocomplete="new-password">
                        @error('password')
                            <span class="text-xs text-red-600 password" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex flex-col mb-4">
                        <label for="password-confirm" class="text-xs py-2 text-gray-700">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="px-2 py-1 w-full border bg-gray-200 rounded" name="password_confirmation" required autocomplete="new-password">
                        @error('password')
                            <span class="text-xs text-red-600 password" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex flex-col mt-4">
                        <div class="self-center mr-2">
                            <button
                                type="submit"
                                id="submit_button"
                                class="bg-transparent hover:bg-indigo-500 text-indigo-700 text-sm font-semibold hover:text-white py-2 px-4 border border-indigo-500 hover:border-transparent rounded"
                                >
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
