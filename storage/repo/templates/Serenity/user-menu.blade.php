@guest
    <span class="flex px-4 py-2 rounded-lg font-bold text-{{$data->ref->template->primaryColor}}-600 hover:bg-gray-100 cursor-pointer"
        @click.stop="isLoginModalOpen = true">
        Login / Sign Up
    </span>
    @include('active.login-modal')

@endguest

@auth

@if(
    $data->ref->contentType === 'single'
    && ($data->user->id === $data->page->author->id
        || $data->user->role === 'admin')
)
    <user-strip :user="authuser"
        :user-menu-open="isUserMenuOpen"
        @user-strip-open="isUserMenuOpen = true"
        @user-strip-close="isUserMenuOpen = false"
        @logout="logout"
        edit-page-link="/app/pages/{{ $data->page->id }}">
    </user-strip>
@else

    <user-strip :user="authuser"
        :user-menu-open="isUserMenuOpen"
        @user-strip-open="isUserMenuOpen = true"
        @user-strip-close="isUserMenuOpen = false"
        @logout="logout">
    </user-strip>
@endif

@endauth