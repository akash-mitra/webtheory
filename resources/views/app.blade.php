<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>WebTheory Control Panel</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

        @yield('css')

        <style>
            .fade-enter-active, .fade-leave-active {
                transition-property: opacity;
                transition-duration: .3s;
            }

            .fade-enter-active {
                transition-delay: 0;
            }

            .fade-enter, .fade-leave-active {
                opacity: 0
            }
        </style>

    </head>

    <body class="bg-gray-200">

        <div class="w-full font-sans" id="app" @click="hideOverlayMenu" v-cloak>

            <div v-if="authUser !== null && authUser.role != 'registered'" class="w-full bg-white border-b border-gray-400 md:flex items-center justify-between">
                <div class="md:flex justify-start items-center overflow-hidden">

                    <div class="py-3 px-6 lg:px-8 flex items-center justify-between">
                        <img src="/images/tensor.svg" alt="WebTheory Dashboard" class="h-10 w-10 mr-4 cursor-pointer" @click="$router.push('/app')">
                        <p class="block md:hidden lg:block text-blue-500 font-bold mr-10">WebTheory</p>

                        <svg id="menu-toggle-button" @click="hamBurgerMenu=!hamBurgerMenu" class="md:hidden text-gray-500 fill-current w-6 h-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path id="menu-toggle-btn-burger" v-if="hamBurgerMenu" d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"></path>
                            <path id="menu-toggle-btn-x" v-else d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                        </svg>
                    </div>

                    <nav id="nav-menu" :class="hamBurgerMenu?'':'hidden'" class="md:flex w-full max-w-4xl overflow-x-auto space-x-0 md:space-x-8 xl:space-x-12">

                        <router-link class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-1" to="/app/pages">
                            Pages
                        </router-link>


                        <router-link class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-2" to="/app/categories">
                            Categories
                        </router-link>


                        <router-link class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-3" to="/app/gallery">
                            Gallery
                        </router-link>


                        <router-link class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-4" to="/app/users">
                            Users
                        </router-link>


                        <router-link v-if="authUser.role == 'admin'" class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-5" to="/app/templates">
                            Templates
                        </router-link>

                        <router-link v-if="authUser.role == 'admin'" class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-6" to="/app/forms">
                            Forms
                        </router-link>


                        <router-link v-if="authUser.role == 'admin'" class="block tracking-wide outline-none border-t md:border-none text-sm py-3 px-6 md:px-0" active-class="font-bold text-blue-700" id="nav-menu-7" to="/app/settings">
                            Settings
                        </router-link>

                    </nav>

                </div>

                <div id="user-menu" :class="hamBurgerMenu?'':'hidden'" class="py-3 border-t md:border-none md:block relative md:px-6 lg:px-8 justify-end md:py-0">
                    <img :src="authUser.avatar" :alt="authUser.name" :title="authUser.name" id="auth-user-avatar" class="ml-6 md:ml-0 h-10 w-10 border rounded-full cursor-pointer" @click='showDropdownMenu = !showDropdownMenu'/>
                    <div class="w-full md:w-56 md:absolute z-50 right-0 mt-3 mr-6 bg-white border-t md:shadow-lg" v-if="showDropdownMenu">
                        <div class="px-6 py-2 border-b cursor-pointer bg-gray-100">
                            <p v-text="authUser.name" class="text-sm font-bold truncate"></p>
                            <p v-text="authUser.role" class="text-sm font-mono"></p>
                        </div>
                        <div class="px-6 py-2 border-b cursor-pointer hover:bg-gray-100">Account</div>
                        <div class="px-6 py-2 border-b cursor-pointer hover:bg-gray-100" id="loform" @click="logout">Logout</div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <transition name="fade" mode="out-in">

                    <router-view></router-view>
                </transition>
            </div>

            <form method="post" action="/logout" id="loform" ref="loform">@csrf</form>
        </div>


        <script src="{{ mix('/js/app.js') }}"></script>

        @yield('script')

        <script>

            let app = new Vue({
                el: '#app',
                router: router,
                data: {
                    authUser: @json($authUser),
                    showDropdownMenu: false,
                    hamBurgerMenu: false,
                    keyboardMap: {
                        // order is: keycode.alt.ctrl.shift
                        '67': (p) => { p.browseToRoute ('categories.index') },
                        '80': (p) => { p.browseToRoute ('pages.index') },
                        '71': (p) => { p.browseToRoute ('gallery.index') },
                        '85': (p) => { p.browseToRoute ('users.index') },
                        '84': (p) => { p.browseToRoute ('templates.index') },
                        '70': (p) => { p.browseToRoute ('forms.index') },
                        '83': (p) => { p.browseToRoute ('settings.index') },
                    }
                },

                mounted() {
                    window.document.addEventListener('keydown', this.keyboardHook)
                },
                beforeDestroy() {
                    window.document.removeEventListener('keydown', this.keyboardHook)
                },

                watch: {
                    $route: function(to) {
                        this.$nextTick(function () {
                            // Change document title
                            document.title = to.meta.title || 'WebTheory Control Panel'
                        });
                    }
                },

                methods: {

                    keyboardHook(event) {

                        let e = event || window.event
                        let target = e.target || e.srcElement
                        let tag = target.tagName.toUpperCase()

                        //console.log('detected command:' + cmd)

                        // do not do anything if the key is pressed in a input field
                        // or content editable field.
                        if (tag == 'INPUT') return;
                        if (tag == 'TEXTAREA') return;
                        if (tag == 'SELECT') return;
                        if (target.isContentEditable) return;

                        // determine the keyboard command
                        let cmd = (e.which || e.keyCode)
                                    + (e.altKey? '.alt' : '')
                                    + (e.ctrlKey? '.ctrl': '')
                                    + (e.shiftKey? '.shift' : '')

                        // if an action is defined for the command, call it.
                        if (this.keyboardMap.hasOwnProperty(cmd)) {
                            this.keyboardMap[cmd](this)
                        }

                        //console.log(cmd)
                    },

                    browseToRoute(name) {
                        if (this.$route.name != name) {
                            this.$router.push({name: name})
                        }
                    },

                    hideOverlayMenu (e) {
                        if(e.target.id != 'auth-user-avatar') this.showDropdownMenu = false;
                    },

                    logout() {
                        this.$refs.loform.submit()
                    },
                }
            })
        </script>

    </body>
</html>