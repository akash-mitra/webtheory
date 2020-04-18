@if( $data->user != null )
    <div x-data="{ userMenuOpen: false }" @keydown.escape="userMenuOpen = false" @click.away="userMenuOpen = false" class="relative inline-block text-left">
        <div>

            <button @click="userMenuOpen = !userMenuOpen" type="button" class="inline-flex justify-center items-center w-full rounded py-2 bg-white hover:bg-gray-1001 text-sm font-medium transition ease-in-out duration-150">
            <span class="flex items-center px-4">
                <img src="{{ $data->user->avatar }}" class="h-12 w-12 rounded-full border" />
                <span class="hidden sm:flex ml-4 text-lg text-gray-800">{{ $data->user->name }}</span>
            </span>
            <svg class="ml-1 pr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
            </button>

        </div>
        <div x-show="userMenuOpen" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 w-56 rounded shadow-lg">
        <div class="rounded bg-white border shadow-xs">
            <div class="border-b">
                <a href="{{ $data->user->url }}" class="block px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Profile</a>
            </div>

            @if($data->user->isAdmin())
            <div class="border-b">
                <a href="/app" target="_blank" class="block px-4 py-4 tracking-wide text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:bg-gray-100 focus:text-gray-900">Admin Panel</a>
            </div>
            @endif

            @if(! empty($data->page))
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

@else
<span class="flex px-4 py-2 rounded-lg hover:bg-gray-100 cursor-pointer" @click="showLoginModal = true">
    Login
</span>
@endif