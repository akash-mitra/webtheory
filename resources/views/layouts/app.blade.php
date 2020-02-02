<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200">
    <div class="w-full font-sans" id="app">
        <div class="w-full bg-white border-b border-gray-400 py-3 md:flex items-center justify-between">
            <div class="md:flex justify-start items-center">
                <div class="px-6 lg:px-8 flex items-center justify-between">
                    <img src="/images/tensor.svg" alt="WebTheory Home" class="h-10 w-10 mr-6">
                    <p class="hidden md:block text-blue-400 font-thin mr-10">{{ config('app.name', 'Laravel') }}</p>

                    <svg id="menu-toggle-button" class="md:hidden text-gray-500 fill-current w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path id="menu-toggle-btn-burger" class="hidden" d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
                        <path id="menu-toggle-btn-x" d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </div>

                <nav id="nav-menu" class="hidden md:block px-4 lg:px-8 md:flex py-4 md:py-0 w-full max-w-4xl">
                    
                </nav>

            </div>

            @guest
                <div id="home-menu" class="hidden md:block relative px-6 lg:px-8 justify-end py-2 md:py-0">
                    <p class="px-2 md:px-6 tracking-wide text-sm py-2">
                        <a class="text-blue-700" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a class="text-blue-700 ml-4" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </p>
                </div>
            @else
                <div id="user-menu" class="hidden md:block relative px-6 lg:px-8 justify-end py-2 md:py-0">
                    <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}" class="h-10 w-10 border rounded-full cursor-pointer" @click='showDropdownMenu = !showDropdownMenu'/>
                    <div class="w-56 md:absolute z-50 right-0 mt-3 mr-6 bg-white border-t shadow-lg" v-if="showDropdownMenu">
                        <div class="px-6 py-2 border-b cursor-pointer bg-gray-100">
                            <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-sm font-mono">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="px-6 py-2 border-b cursor-pointer hover:bg-gray-100"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"
                        >
                        {{ __('Logout') }}
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                    </div>
                </div>
            @endguest

        </div>

        <div class="w-full">
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script>

        const toggleBtn = document.getElementById('menu-toggle-button'),
            navMenu = document.getElementById('nav-menu'),
            userMenu = document.getElementById('user-menu'),
            toggleBtnBurger = document.getElementById('menu-toggle-btn-burger'),
            toggleBtnX = document.getElementById('menu-toggle-btn-x');
    
        toggleBtn.addEventListener('click', function () {
            navMenu.classList.toggle('hidden');
            userMenu.classList.toggle('hidden');
            toggleBtnBurger.classList.toggle('hidden');
            toggleBtnX.classList.toggle('hidden');
        })
    
    </script>
</body>
</html>
