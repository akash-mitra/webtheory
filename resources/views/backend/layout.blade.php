<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BlogTheory - Admin Panel</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap" rel="stylesheet">
        @yield('css')

    </head>

    <body class="font-sans bg-white">
       
        <div class="w-full max-h-screen overflow-hidden" id="app">

            <div class="w-full bg-gray-900 flex h-16 items-center pat-2">
                <div class="w-1/5">
                    @include('backend.partials.top-menu-left')
                </div>
                <div class="w-4/5">
                    @include('backend.partials.top-menu-right')
                </div>
            </div>


            <div class="w-full bg-white flex items-center relative inset-x-0 top-0 h-16 shadow">
                <div class="w-1/6 lg:w-1/5">
                    @include('backend.partials.secondary-menu-left')
                </div>
                <div class="w-5/6 lg:w-4/5">
                    
                    @yield('ribbon')
                </div>
            </div>

            <div class="md:flex">

                <aside id="nav-menu" class="hidden md:block md:w-1/5 bg-gray-700">
                    @include('backend.partials.left')
                </aside>

                <main class="w-full md:w-4/5">
                    @yield('main')
                </main>
            </div>

        </div>

        <div class="w-full"></div>

        
        
        <script src="{{ mix('/js/app.js') }}"></script>
        @yield('script')

        @include('backend.partials.hamburger-script')
    </body>
</html>