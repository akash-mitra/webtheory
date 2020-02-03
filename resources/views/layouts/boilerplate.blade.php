<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <title>
            @yield('title')
        </title>
        <meta name="description" content="@yield('metadesc')">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        @yield('css')

        <meta name="theme-color" content="#fafafa">
    </head>
    <body>

        @yield('main')

        @yield('js')

    </body>
</html>