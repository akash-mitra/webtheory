<div id="wt-login-wrap">
    <div id='wt-login-header'>
        <div id='wt-login-icon'>Icon</div>
        <div id='wt-login-title'>
            <div id='wt-login-signin-text'>Sign in to your account</div>
            <div id='wt-login-create-text'>Create New Account</div>
        </div>
    </div>


    <form class="wt-login-body" action="/login" method="POST">
        @csrf
        <input type="hidden" name="loginFormType" value="login">
        <input type="hidden" name="remember" value="true">


        <div class="wt-login-items">
            <div class="wt-login-inp-wrap">
                <label for="email" class='wt-login-inp-lbl'>Email address</label>
                <input aria-label="Email Address" name="email" id="email" type="email" required
                       autocomplete="email"
                       class="wt-login-inp"
                       placeholder="john@email.com"
                       value="{{ old('email') }}">

                @if($errors->has('email') && old('loginFormType') === 'login')
                    <div class="wt-login-err-txt">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="wt-login-inp-wrap">
                <label for="password" class="wt-login-inp-lbl">Password</label>
                <input aria-label="Password" name="password" id="password" type="password" required=""
                       autocomplete="current-password"
                       class="wt-login-inp"
                       placeholder="********">
            </div>
        </div>

        <div class="wt-login-setting">
            <div>
                <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember" class="wt-login-remember">
                    Remember me
                </label>
            </div>

            <div>
                <a href="#" class="wt-login-forgot-pass">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div>
            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <!-- Heroicon name: solid/lock-closed -->
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
              </span>
                Sign in
            </button>
        </div>
    </form>
</div>
