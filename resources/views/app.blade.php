<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WebTheory - Admin Panel</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">

        @yield('css')

    </head>

    <body class="bg-gray-200">

    <div class="w-full font-sans" id="app">
       
        <div class="w-full bg-white border-b border-gray-400 py-3 md:flex items-center justify-between">
            <div class="md:flex justify-start items-center">
                <div class="px-6 lg:px-8 flex items-center justify-between">
                    <img src="/images/tensor.svg" alt="WebTheory Home" class="h-10 w-10 mr-6"> 
                    <p class="hidden md:block text-blue-400 font-thin mr-10">WebTheory</p>

                    <svg id="menu-toggle-button" class="md:hidden text-gray-500 fill-current w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path id="menu-toggle-btn-burger" class="hidden" d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
                        <path id="menu-toggle-btn-x" d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </div>

                <nav id="nav-menu" class="hidden md:block px-4 lg:px-8 md:flex py-4 md:py-0 w-full max-w-4xl">
                    <p class="px-2 md:px-6 tracking-wide text-sm py-2 text-blue-700">
                        <router-link to="/app/pages">
                            Pages
                        </router-link>
                    </p>
                    <p class="px-2 md:px-6 tracking-wide text-sm py-2 text-gray-500">Categories</p>
                    <p class="px-2 md:px-6 tracking-wide text-sm py-2 text-gray-500">Settings</p>
                </nav>

            </div>

            <div id="user-menu" class="hidden md:block px-6 lg:px-8 justify-end py-2 md:py-0">
                <img src="https://i.pravatar.cc/60" alt="user pic" class="h-10 w-10 border rounded-full" />
            </div>

        </div>
        
        

        <div class="w-full">
            
            <router-view></router-view>
        </div>


    </div>


    <script src="{{ mix('/js/app.js') }}"></script>

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

    @yield('script')

        
    </body>
</html>