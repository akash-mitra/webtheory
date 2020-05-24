<!doctype html>
<html lang="en-us">

<head>
  <meta charset="utf-8">

  @yield('title')

  <meta name="description" content="@yield('metadesc')">

  <meta name="keywords" content="@yield('metakeys')">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="theme-color" content="#fafafa">

  <link href="/css/style-{{$data->ref->template->primaryColor}}.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family={{ str_replace(' ', '+', $data->ref->template->headingFont) }}|Quicksand&display=swap" rel="stylesheet">

  <style>
    .font-heading {
        font-family: "{{ $data->ref->template->headingFont }}", serif;
    }

    .font-reading {
        font-family: 'Quicksand', sans-serif;
    }
  </style>

  @stack('styles')

  @stack('headers')

</head>

<body>
    
    @if($data->ref->comment->facebook_client_id !='')
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src={{ "https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v7.0&appId=" . $data->ref->comment->facebook_client_id . "&autoLogAppEvents=1" }}></script>
    @endif

    <div style="width: 100%; height: 100%; margin: 0; padding: 0;"
        id="js-playground"
        v-cloak
        @click="discardModalsAndPopups($event)">

        @yield('contents')

    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script> --}}
    <script src="https://vuejs.org/js/vue.js"></script>

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

                authuser: @json($data->user)
            },

            created() {},

            methods: {
                discardModalsAndPopups() {
                    this.isUserMenuOpen = this.isLoginModalOpen = false
                }
            }
        });
    </script>

    @stack('post-scripts')

</body>
</html>