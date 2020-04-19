<style>
.duration-300 {
    transition-duration: 300ms;
}
.ease-in {
    transition-timing-function: cubic-bezier(0.4, 0, 1, 1);
}
.ease-out {
    transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
}
.scale-60 {
    transform: scale(.6);
}
.scale-100 {
    transform: scale(1);
}

.kiwi {
    background-color: #ffffff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='34' height='44' viewBox='0 0 34 44'%3E%3Cg fill='%23ebf4ff' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M1 6.2C.72 5.55.38 4.94 0 4.36v13.28c.38-.58.72-1.2 1-1.84A12.04 12.04 0 0 0 7.2 22 12.04 12.04 0 0 0 1 28.2c-.28-.65-.62-1.26-1-1.84v13.28c.38-.58.72-1.2 1-1.84A12.04 12.04 0 0 0 7.2 44h21.6a12.05 12.05 0 0 0 5.2-4.36V26.36A12.05 12.05 0 0 0 28.8 22a12.05 12.05 0 0 0 5.2-4.36V4.36A12.05 12.05 0 0 0 28.8 0H7.2A12.04 12.04 0 0 0 1 6.2zM17.36 23H12a10 10 0 1 0 0 20h5.36a11.99 11.99 0 0 1 0-20zm1.28-2H24a10 10 0 1 0 0-20h-5.36a11.99 11.99 0 0 1 0 20zM12 1a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 14a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-3.46-2a2 2 0 1 0-3.47 2 2 2 0 0 0 3.47-2zm0-4a2 2 0 1 0-3.47-2 2 2 0 0 0 3.47 2zM12 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3.46 2a2 2 0 1 0 3.47-2 2 2 0 0 0-3.47 2zm0 4a2 2 0 1 0 3.47 2 2 2 0 0 0-3.47-2zM24 43a10 10 0 1 0 0-20 10 10 0 0 0 0 20zm0-14a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3.46 2a2 2 0 1 0 3.47-2 2 2 0 0 0-3.47 2zm0 4a2 2 0 1 0 3.47 2 2 2 0 0 0-3.47-2zM24 37a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-3.46-2a2 2 0 1 0-3.47 2 2 2 0 0 0 3.47-2zm0-4a2 2 0 1 0-3.47-2 2 2 0 0 0 3.47 2z'/%3E%3C/g%3E%3C/svg%3E");
}


input:-webkit-autofill {
  -webkit-box-shadow: inset 0 0 0px 9999px white;
}

input:-webkit-autofill::first-line {
    font-size: 0.875rem !important;
}

</style>

<div class="overflow-auto"
    style="background-color: rgba(10,20,30, 0.8)"
    x-show="showLoginModal"
    :class="{ 'absolute inset-0 z-10 flex items-center justify-center': showLoginModal }">
    <!--Dialog-->


    <div
      class="bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg text-left"
      @click.away="showLoginModal = false"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 scale-60"
      x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="ease-in duration-300"
      x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-60"
    >

    @if($errors->hasBag('register'))
    <div x-data="{ mode: 'signup' }">
    @elseif($errors->hasBag('forgot'))
    <div x-data="{ mode: 'forgot' }">
    @else
    <div x-data="{ mode: 'login' }">
    @endif

        <div x-show="mode==='signup'">
            <div class="py-6 px-6 flex justify-between items-center border-b">

                <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">Sign Up</div>

                <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current"><g><path class="secondary" d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z"/><path class="primary" d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z"/></g></svg>
                </div>

                <div class="w-1/3 text-right">
                    <span @click="mode='login'" class="text-sm text-blue-600 cursor-pointer">Have Login?</span>
                </div>

            </div>

            <div class="px-6 pt-6 pb-12 shadow-inner">

                <form action="/register" method="POST">
                    @csrf

                    @if ($errors->register->any())
                        <div class="font-bold mb-2 text-xs">Please correct the errors below and re-try.</div>
                    @endif
                    <div class="w-full mb-4">
                        <label for="name" class="tracking-wider block text-gray-700 text-sm mb-2">Your Name</label>
                        <input aria-label="name" name="name" id="name" type="text" required autocomplete="off"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="John Doe"
                            value="{{ old('name') }}">

                        @error('name', 'register')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="w-full mb-4">
                        <label for="register_email" class="tracking-wider block text-gray-700 text-sm mb-2">Email Address</label>
                        <input aria-label="Email address" name="email" id="register_email" type="email" required autocomplete="username"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="john@email.com"
                            value="{{ old('email') }}">

                        <label for="register_email_confirmed" class="block text-gray-700 text-sm mb-2 mt-4">Re-type Email Address</label>
                        <input aria-label="Confirm Email Address" name="email_confirmation" id="register_email_confirmed" type="email" required
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="john@email.com"
                            value="{{ old('email_confirmation') }}">

                        @error('email', 'register')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="register_password" class="tracking-wider block text-gray-700 text-sm mb-2">Choose a Password</label>
                        <input aria-label="Password" name="password" id="register_password" type="password" required autocomplete="off"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="********">

                        @error('password', 'register')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full py-2 px-3 rounded border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                        Sign Up
                        </button>
                    </div>
                </form>
            </div>

        </div>


        <div x-show="mode==='login'">


            <div class="py-6 px-6 flex justify-between items-center border-bw">

                <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">Login</div>

                <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current"><g><path class="secondary" d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z"/><path class="primary" d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z"/></g></svg>
                </div>

                <div class="w-1/3 text-right">
                    <span @click="mode='signup'" class="text-sm text-blue-600 cursor-pointer">New Account?</span>
                </div>

            </div>

            <div class="px-6 pt-6 pb-12 shadow-inner">

                <form action="/login" method="POST">
                    @csrf

                    <input type="hidden" name="remember" value="true">

                    <div class="w-full mb-4">

                        <label for="email" class="block text-gray-700 text-sm mb-2">Email Address</label>
                        <input aria-label="Email Address" name="email" id="email" type="email" required autocomplete="username"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="john@email.com"
                            value="{{ old('email') }}">

                        @error('email')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="w-full">
                        <label for="password" class="block text-gray-700 text-sm mb-2 flex justify-between">
                            Password
                            <span @click="mode='forgot'" class="text-sm text-blue-400 hover:text-blue-600 cursor-pointer">Forgot?</span>
                        </label>
                        <input aria-label="Password" name="password" id="password" type="password" required="" autocomplete="current-password"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="********">
                        @error('password')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full rounded py-2 px-3 border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                        Log in

                        </button>
                    </div>
                </form>
            </div>

        </div>


        <div x-show="mode==='forgot'">
            <div class="py-6 px-6 flex justify-between items-center border-b">

                <div class="w-1/3 text-left text-3xl text-{{$data->ref->template->primaryColor}}-600 font-light">Recovery</div>

                <div class="-mt-16 bg-white p-4 shadow-lg rounded-full border inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-8 h-8 -mt-1 text-{{$data->ref->template->primaryColor}}-700 fill-current"><g><path class="secondary" d="M12 10v3a2 2 0 0 0-1 3.73V18a1 1 0 0 0 1 1v3H5a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h7z"/><path class="primary" d="M12 19a1 1 0 0 0 1-1v-1.27A2 2 0 0 0 12 13v-3h3V7a3 3 0 0 0-6 0v3H7V7a5 5 0 1 1 10 0v3h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-7v-3z"/></g></svg>
                </div>

                <div class="w-1/3 text-right">
                    <span @click="mode='login'" class="text-sm text-blue-600 cursor-pointer">Go to Login</span>
                </div>

            </div>

            <div class="px-6 pt-6 pb-12 shadow-inner">

                <form action="/password/email" method="POST">
                    @csrf

                    <div class="w-full mb-4">

                        <label for="email" class="block text-gray-700 text-sm mb-2">Email Address</label>
                        <input aria-label="Email Address" name="email" id="email" type="email" required autocomplete="username"
                            class="px-3 py-2 border text-gray-900 bg-gray-100 rounded placeholder-gray-600 appearance-none w-full sm:text-sm sm:leading-5 outline-none"
                            placeholder="john@email.com"
                            value="{{ old('email') }}">

                        @error('email', 'forgot')
                            <div class="p-2 bg-red-100 text-red-700 mb-2 text-xs">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full rounded py-2 px-3 border border-transparent rounded-md text-white font-semibold bg-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-700 focus:bg-{{$data->ref->template->primaryColor}}-900 focus:outline-none focus:shadow-outline sm:text-sm sm:leading-5">
                            Send Password Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>


        @if($data->ref->login->socialprovider->google === 'Enabled'
        || $data->ref->login->socialprovider->facebook === 'Enabled'
        || $data->ref->login->socialprovider->twitter === 'Enabled')

        <div class="px-6 py-2 border-b kiwi rounded-b">

            <div class="w-full bg-transparent -mt-6 flex justify-center">
                <span class="text-sm text-gray-600 bg-white px-8 py-1 tracking-wide rounded-lg border shadow">Skip the Hassle, Go Social.</span>
            </div>

            <div class="pt-6 pb-4 px-6 flex items-center justify-around">

                @if(($data->ref->login->socialprovider->google === 'Enabled'))
                <div class="p-2 cursor-pointer text-center flex flex-col items-center text-gray-500 hover:text-red-600 mx-2">
                    <svg role="img" viewBox="0 0 24 24" class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg"><title>Google icon</title><path d="M12.24 10.285V14.4h6.806c-.275 1.765-2.056 5.174-6.806 5.174-4.095 0-7.439-3.389-7.439-7.574s3.345-7.574 7.439-7.574c2.33 0 3.891.989 4.785 1.849l3.254-3.138C18.189 1.186 15.479 0 12.24 0c-6.635 0-12 5.365-12 12s5.365 12 12 12c6.926 0 11.52-4.869 11.52-11.726 0-.788-.085-1.39-.189-1.989H12.24z"/></svg>
                    Google
                </div>
                @endif

                @if(($data->ref->login->socialprovider->facebook === 'Enabled'))
                <div class="p-2 cursor-pointer text-center flex flex-col items-center text-gray-500 hover:text-blue-700 mx-2">
                    <svg role="img" viewBox="0 0 24 24" class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg"><title>Facebook icon</title><path d="M23.9981 11.9991C23.9981 5.37216 18.626 0 11.9991 0C5.37216 0 0 5.37216 0 11.9991C0 17.9882 4.38789 22.9522 10.1242 23.8524V15.4676H7.07758V11.9991H10.1242V9.35553C10.1242 6.34826 11.9156 4.68714 14.6564 4.68714C15.9692 4.68714 17.3424 4.92149 17.3424 4.92149V7.87439H15.8294C14.3388 7.87439 13.8739 8.79933 13.8739 9.74824V11.9991H17.2018L16.6698 15.4676H13.8739V23.8524C19.6103 22.9522 23.9981 17.9882 23.9981 11.9991Z"/></svg>
                    Facebook
                </div>
                @endif

                @if(($data->ref->login->socialprovider->twitter === 'Enabled'))
                <div class="p-2 cursor-pointer text-center flex flex-col items-center text-gray-500 hover:text-blue-500 mx-2">
                    <svg role="img" viewBox="0 0 24 24" class="w-8 h-8 fill-current" xmlns="http://www.w3.org/2000/svg"><title>Twitter icon</title><path d="M23.954 4.569c-.885.389-1.83.654-2.825.775 1.014-.611 1.794-1.574 2.163-2.723-.951.555-2.005.959-3.127 1.184-.896-.959-2.173-1.559-3.591-1.559-2.717 0-4.92 2.203-4.92 4.917 0 .39.045.765.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.722-.666 1.561-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.39 0-.779-.023-1.17-.067 2.189 1.394 4.768 2.209 7.557 2.209 9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63.961-.689 1.8-1.56 2.46-2.548l-.047-.02z"/></svg>
                    Twitter
                </div>
                @endif

            </div>

        </div>

        @endif
    </div>

    </div><!--/Dialog -->
</div><!-- /Overlay -->