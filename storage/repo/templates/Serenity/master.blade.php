<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">

  @yield('title')

  <meta name="description" content="@yield('metadesc')">

  <meta name="keywords" content="@yield('metakeys')">

  <meta name="generator" content="webtheory">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="theme-color" content="#fafafa">

  <link href="/css/serenity.{{$data->ref->template->primaryColor}}.css" rel="stylesheet">
  {{-- <link href="/css/style.css" rel="stylesheet"> --}}

  @favicon



  @if(!empty(optional($data->ref->template)->headingFont))
    <link href="https://fonts.googleapis.com/css?family={{ str_replace(' ', '+', $data->ref->template->headingFont) }}&display=swap" rel="stylesheet">
    <style>
        h1, h2, h3, h4, h5, h6 {
            font-family: "{{ $data->ref->template->headingFont }}", serif;
        }
    </style>
  @else
    <style>
        h1, h2, h3, h4, h5, h6 {
            font-family: serif;
        }
    </style>
  @endif

  @if(!empty(optional($data->ref->template)->readingFont))
    <link href="https://fonts.googleapis.com/css?family={{ str_replace(' ', '+', $data->ref->template->readingFont) }}&display=swap" rel="stylesheet">
    <style>
        p {
            font-family: "{{ $data->ref->template->readingFont }}", sans-serif;
        }
    </style>
  @else
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <style>
        p {
            font-family: Quicksand, sans-serif;
        }
    </style>
  @endif

  @stack('styles')

  @stack('headers')

</head>

<body>

    <div style="width: 100%; height: 100%; margin: 0; padding: 0;"
        id="js-playground"
        v-cloak
        @click="discardModalsAndPopups"
        @keydown.esc="discardModalsAndPopups"
    >

        @yield('contents')

        <footer class="w-full flex flex-col bg-gray-100 items-center mt-6 p-6 border-t text-gray-600 rounded-lg">
            <p class="p-2">
                <a href="/terms">Terms of Use</a> |
                <a href="/privacy">Privacy Policy</a> |
                <a href="/sitemap">Sitemap</a>
            </p>
            <p class="p-2">&copy; <?php echo date('Y') ?> - All Rights Reserved. </p>
            <p class="p-2 text-{{$data->ref->template->primaryColor}}-600"><a href="https://webtheory.co">Made with WebTheory</a></p>
        </footer>

        <form method="post" action="/logout" id="loform" ref="loform">@csrf</form>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script> --}}
    {{-- <script src="https://vuejs.org/js/vue.js"></script> --}}

    <script src="{{ mix('/js/frontend.js') }}"></script>

    <script>
        window.csrf_token="{{ csrf_token() }}"
    </script>

    @stack('pre-scripts')

    <script>
        const v = new Vue({

            el: '#js-playground',

            data: {

                @if(empty(old('loginFormType') ))
                isLoginModalOpen: false,
                @else
                isLoginModalOpen: true,
                @endif

                @switch(old('loginFormType'))
                    @case('registration')
                        mode: 'signup',
                    @break
                    @case('forgot')
                        mode: 'forgot',
                    @break
                    @default
                        mode: 'login',
                @endswitch

                isUserMenuOpen: false,

                authuser: @json($data->user),

            },

            methods: {
                discardModalsAndPopups() {
                    this.isUserMenuOpen = this.isLoginModalOpen = false
                },

                logout() {
                    this.$refs.loform.submit()
                }
            }
        });
    </script>

    @stack('post-scripts')

</body>
</html>