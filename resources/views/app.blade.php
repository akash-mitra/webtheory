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

    <body>

    <div class="font-sans bg-gray-300 min-h-screen" id="app">
       
        <div class="w-full px-8 bg-white border-b border-gray-400 h-16 flex items-center justify-between">
            <img src="/images/tensor.svg" alt="WebTheory Home" class="h-10 w-10"> 
            <nav>
            
            </nav>
            <img src="https://i.pravatar.cc/60" alt="user pic" class="h-10 w-10 rounded-full" />
        </div>

        

        <div class="w-full max-w-6xl1 mx-auto px-8 bg-gray-300">
            
            <router-view></router-view>
        </div>


    </div>


    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('script')

        
    </body>
</html>