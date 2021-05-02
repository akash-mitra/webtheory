@switch($api->type())
    @case('page')
        @includeFirst(['active.page-new', 'default.master'])
    @break

    @case('category')
        @includeFirst(['active.category-new', 'default.master'])
    @break

    @case('profile')
        @includeFirst(['active.profile-new', 'default.master'])
    @break

    @case('form')
        @includeFirst(['active.form-new', 'default.master'])
    @break

    @default
        @includeFirst(['active.home-new', 'default.master'])

@endswitch
