@guest
    <span class="flex px-4 py-2 rounded-lg font-bold text-{{$data->ref->template->primaryColor}}-600 hover:bg-gray-100 cursor-pointer"
        @click.stop="isLoginModalOpen = true">
        Login
    </span>
    @include('active.login-modal')

@endguest

@auth
    <div class="relative inline-block text-left focus:outline-none" @click.stop @keydown.esc="discardModalsAndPopups($event)" tabindex="-10">

        <button @click="isUserMenuOpen = !isUserMenuOpen" type="button" class="inline-flex justify-center items-center w-full rounded py-2 bg-white hover:bg-gray-1001 text-sm font-medium transition ease-in-out duration-150">
            <span class="flex items-center px-4">
                <img src="{{ $data->user->avatar }}" class="h-12 w-12 rounded-full border-2" />
                <span class="hidden sm:flex ml-4 text-lg text-gray-800">{{ $data->user->name }}</span>
            </span>
            <svg class="ml-1 pr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>

        <div v-if="isUserMenuOpen" class="origin-top-right absolute right-0 w-56 rounded shadow-lg">
            <div class="rounded bg-white border shadow-xs">

            @if(empty($data->user->email_verified_at))
            <div class="border-b">
                <div class="flex px-4 py-4 tracking-wide text-gray-700">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 24 24">
                        <desc>Email Not Verified</desc>
                        <title>Email Not Verified</title>
                        <path class="text-red-200" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20z"/>
                        <path class="text-red-600" d="M12 18a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm1-5.9c-.13 1.2-1.88 1.2-2 0l-.5-5a1 1 0 0 1 1-1.1h1a1 1 0 0 1 1 1.1l-.5 5z"/>
                    </svg>
                    Email Not Verified
                </div>
            </div>
            @endif

            <div class="border-b">
                <a href="{{ $data->user->url }}" class="block px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Profile</a>
            </div>

            @if($data->user->isAdmin())
            <div class="border-b">
                <a href="/app" target="_blank" class="block px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Admin Panel</a>
            </div>
            @endif

            @if(! empty($data->page) && ($data->user->id === $data->page->author->id || $data->user->role === 'admin'))
            <div class="border-b">
                <a href="/app/pages/{{ $data->page->id }}" target="_blank" class="block px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Edit this page</a>
            </div>
            @endif

            <div class="bg-gray-100">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="block px-4 py-4 tracking-wide w-full text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Logout</button>
                </form>
            </div>

        </div>
        </div>
    </div>

@endauth