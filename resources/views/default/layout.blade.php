<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">

        <title>{{ $api->title() }}</title>

        <script type="module">
            document.documentElement.classList.remove('no-js');
            document.documentElement.classList.add('js');
        </script>

        <link href="/css/default.css" rel="stylesheet">

        <meta name="generator" content="webTheory">
        <meta name="description" content="{{ $api->description() }}">
        <meta property="og:title" content="{{ $api->title() }}">
        <meta property="og:description" content="{{ $api->description() }}">
        <meta property="og:image" content="{{ $api->image() }}">
        <meta property="og:image:alt" content="{{ $api->title() }}">
        <meta property="og:locale" content="en_US">
        <meta property="og:type" content="website">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="og:url" content="{{ $api->url() }}">
        <link rel="canonical" href="{{ $api->url() }}">
{{--        <link rel="icon" href="/favicon.ico">--}}
        <link rel="icon" href="{{ $api->site()->favicon() }}" type="image/svg+xml">
{{--        <link rel="apple-touch-icon" href="/apple-touch-icon.png">--}}
{{--        <link rel="manifest" href="/my.webmanifest">--}}
        <meta name="theme-color" content="{{ $api->template()->themeColor() }}">
        <meta name="keywords" content="{{ $api->tags() }}">

        @stack('styles')
        @stack('headers')

    </head>
    <body>
        <div class='container'>
            <div class='site-top'>
                @yield('top')
            </div>
            <div class='site-mid'>
                <main class='site-main'>
                    @yield('contents')
                </main>
                <aside class='site-aside'>
                    @yield('aside')
                </aside>
            </div>
            <div class='site-bottom'>
                @yield('bottom')
            </div>
        </div>
        @stack('pre-scripts')
        <script type="module" src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js"></script>
        <script nomodule src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine-ie11.min.js" defer></script>
        @stack('post-scripts')
    </body>
</html>
