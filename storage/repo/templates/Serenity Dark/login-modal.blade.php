@push('styles')
    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: inset 0 0 0px 9999px white;
        }

        input:-webkit-autofill::first-line {
            font-size: 0.875rem !important;
        }

        .grecaptcha-badge {
            visibility: hidden;
        }
    </style>
@endpush

@php
    $captcha_key = json_decode(\App\Parameter::getKey('captcha_service'));
    $captcha_site_key = $captcha_key ? $captcha_key->site_key : "";
@endphp

@if($captcha_site_key != "")
    @push('post-scripts')
        <script src="https://www.google.com/recaptcha/api.js?render={{$captcha_site_key}}"></script>
        <script>
            function submit_register_form(e)
            {
                e.preventDefault();
                grecaptcha.ready(function() {
                    grecaptcha.execute("{{$captcha_site_key}}", {action: 'submit'}).then(function(token) {
                        document.getElementById('wt_recaptcha_token').value = token
                        document.getElementById('registerForm').submit()
                    });
                });

            }
        </script>
    @endpush
@endif

<div class="overflow-auto"
     style="background-color: rgba(10,20,30, 0.8)"
     v-if="isLoginModalOpen"
     :class="isLoginModalOpen ? 'fixed inset-0 z-10 flex items-center justify-center':''"
>

    <div class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg text-left" @click.stop>

        <div v-if="mode==='signup'">
            <div class="py-6 px-6 flex justify-between items-center border-b">

                <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">Sign Up</div>

                <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current">
                        <g>
                            <path class="secondary"
                                  d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z" />
                            <path class="primary"
                                  d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z" />
                        </g>
                    </svg>
                </div>

                <div class="w-1/3 text-right">
                    <span @click="mode='login'" class="text-sm text-blue-600 cursor-pointer">Have Login?</span>
                </div>

            </div>

            <div class="px-6 pt-6 shadow-inner">

                <form id="registerForm" action="/register" method="POST">
                    @csrf

                    <input type="hidden" name="loginFormType" value="registration">

                    @if ($errors->any() && old('loginFormType') === 'registration')
                        <div class="font-bold mb-2 text-xs">Please correct the errors below and re-try.</div>
                    @endif

                    <div class="w-full mb-4">
                        <label for="name" class="tracking-wider block text-gray-700 text-sm mb-2">Your Name</label>
                        <input aria-label="name" name="name" id="name" type="text" required autocomplete="off"
                               class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                               placeholder="John Doe"
                               value="{{ old('name') }}">

                        @error('name')
                        <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="w-full mb-4">
                        <label for="register_email" class="tracking-wider block text-gray-700 text-sm mb-2">Email
                            Address</label>
                        <input aria-label="Email address" name="email" id="register_email" type="email" required
                               autocomplete="username"
                               class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                               placeholder="john@email.com"
                               value="{{ old('email') }}">

                        <label for="register_email_confirmed" class="block text-gray-700 text-sm mb-2 mt-4">Re-type
                            Email Address</label>
                        <input aria-label="Confirm Email Address" name="email_confirmation"
                               id="register_email_confirmed" type="email" required
                               class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                               placeholder="john@email.com"
                               value="{{ old('email_confirmation') }}">

                        @if($errors->has('email') && old('loginFormType') === 'registration')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="w-full">
                        <label for="register_password" class="tracking-wider block text-gray-700 text-sm mb-2">Choose a
                            Password</label>
                        <input aria-label="Password" name="password" id="register_password" type="password" required
                               autocomplete="new-password"
                               class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                               placeholder="********">

                        @if($errors->has('password') && old('loginFormType') === 'registration')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <input type="hidden" name="wt_recaptcha_token" value="" id="wt_recaptcha_token">

                    <div class="mt-4">
                        @if($captcha_site_key != "")
                            <div class="text-xs pb-4 text-gray-400">
                                This site is protected by reCAPTCHA and the Google
                                <a class="text-blue-600 underline" href="https://policies.google.com/privacy">Privacy
                                    Policy</a> and
                                <a class="text-blue-600 underline" href="https://policies.google.com/terms">Terms of
                                    Service</a> apply.
                            </div>
                            <button onclick="submit_register_form(event)" type="button"
                                    class="w-full p-3 rounded border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                                Sign Up
                            </button>
                        @else
                            <button type="submit"
                                    class="w-full p-3 rounded border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                                Sign Up
                            </button>
                        @endif
                    </div>
                </form>
            </div>

        </div>


        <div v-if="mode==='login'">


            <div class="p-6 flex justify-between items-center border-b">

                <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">Login
                </div>

                <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current">
                        <g>
                            <path class="secondary"
                                  d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z" />
                            <path class="primary"
                                  d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z" />
                        </g>
                    </svg>
                </div>

                @if(($data->ref->login->socialprovider->webtheory === 'On'))
                    <div class="w-1/3 text-right">
                        <span id="register-form" @click="mode='signup'" class="text-sm text-blue-600 cursor-pointer">New Account?</span>
                    </div>
                @endif

            </div>

            @if(($data->ref->login->socialprovider->webtheory === 'On'))
                <div class="px-6 pt-6 shadow-inner">

                    <form action="/login" method="POST">
                        @csrf

                        <input type="hidden" name="loginFormType" value="login">

                        <input type="hidden" name="remember" value="true">

                        <div class="w-full mb-4">

                            <label for="email" class="block text-gray-700 text-sm mb-2">Email Address</label>
                            <input aria-label="Email Address" name="email" id="email" type="email" required
                                   autocomplete="username"
                                   class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                                   placeholder="john@email.com"
                                   value="{{ old('email') }}">

                            @if($errors->has('email') && old('loginFormType') === 'login')
                                <div
                                    class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $errors->first('email') }}</div>
                            @endif

                        </div>

                        <div class="w-full">
                            <label for="password" class="block text-gray-700 text-sm mb-2 flex justify-between">
                                Password
                                <span @click="mode='forgot'"
                                      class="text-sm text-blue-400 hover:text-blue-600 cursor-pointer">Forgot?</span>
                            </label>
                            <input aria-label="Password" name="password" id="password" type="password" required=""
                                   autocomplete="current-password"
                                   class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                                   placeholder="********">


                            @if($errors->has('password') && old('loginFormType') === 'login')
                                <div
                                    class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $errors->first('password') }}</div>
                            @endif

                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full rounded p-3 border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>


        @if(($data->ref->login->socialprovider->webtheory === 'On'))
            <div v-if="mode==='forgot'">
                <div class="py-6 px-6 flex justify-between items-center border-b">

                    <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">
                        Recovery
                    </div>

                    <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current">
                            <g>
                                <path class="secondary"
                                      d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z" />
                                <path class="primary"
                                      d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z" />
                            </g>
                        </svg>
                    </div>

                    <div class="w-1/3 text-right">
                        <span @click="mode='login'" class="text-sm text-blue-600 cursor-pointer">Go to Login</span>
                    </div>

                </div>

                <div class="px-6 pt-6 shadow-inner">

                    <form action="/password/email" method="POST">
                        @csrf

                        <input type="hidden" name="loginFormType" value="forgot">

                        <div class="w-full mb-4">

                            <label for="reset_email" class="block text-gray-700 text-sm mb-2">Email Address</label>
                            <input aria-label="Email Address" name="email" id="reset_email" type="email" required
                                   autocomplete="username"
                                   class="p-3 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                                   placeholder="john@email.com"
                                   value="{{ old('email') }}">

                            @if($errors->has('email') && old('loginFormType') === 'forgot')
                                <div
                                    class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $errors->first('email') }}</div>
                            @endif

                        </div>

                        <div class="mt-6">
                            <button type="submit"
                                    class="w-full rounded p-3 border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                                Send Password Reset Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif


        @if($data->ref->login->socialprovider->google === 'On'
        || $data->ref->login->socialprovider->facebook === 'On'
        || $data->ref->login->socialprovider->twitter === 'On')

            <div class="px-6 pt-6">

                @if(($data->ref->login->socialprovider->google === 'On'))


                    <a href="{{ route('social.login', 'google') }}"
                       class="w-full rounded-md p-3 mb-3 border flex items-center hover:bg-gray-100">
                        <svg role="img" viewBox="0 0 24 24" class="w-6 h-6 fill-current text-red-600"
                             xmlns="http://www.w3.org/2000/svg"><title>Google icon</title>
                            <path
                                d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z" />
                        </svg>
                        <span class='ml-4 text-gray-700 text-sm'>Login or Sign Up with Google</span>
                    </a>

                @endif

                @if(($data->ref->login->socialprovider->facebook === 'On'))
                    <a href="{{ route('social.login', 'facebook') }}"
                       class="w-full rounded-md p-3 mb-3 border flex items-center hover:bg-gray-100">
                        <svg role="img" viewBox="0 0 24 24" class="w-6 h-6 fill-current text-blue-700"
                             xmlns="http://www.w3.org/2000/svg"><title>Facebook icon</title>
                            <path
                                d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z" />
                        </svg>
                        <span class='ml-4 text-gray-700 text-sm'>Login or Sign Up with Facebook</span>
                    </a>
                @endif

                @if(($data->ref->login->socialprovider->twitter === 'On'))
                    <a href="{{ route('social.login', 'twitter') }}"
                       class="w-full rounded-md p-3 mb-3 border flex items-center hover:bg-gray-100">
                        <svg role="img" viewBox="0 0 24 24" class="w-6 h-6 fill-current text-blue-400"
                             xmlns="http://www.w3.org/2000/svg"><title>Twitter icon</title>
                            <path
                                d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z" />
                        </svg>
                        <span class='ml-4 text-gray-700 text-sm'>Login or Sign Up with Twitter</span>
                    </a>
                @endif

            </div>
        @endif

        <div class='text-xs text-gray-700 bg-gray-100 w-full p-6 border-t mt-6'>
            By continuing you indicate that you agree to <a class="text-blue-600" href='/terms'>Terms of Service</a> and
            <a class="text-blue-600" href='/privacy'>Privacy Policy</a> of the site.
        </div>

    </div><!--/Dialog -->
</div><!-- /Overlay -->
