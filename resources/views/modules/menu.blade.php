<nav>
    <div class="flex flex-no-wrap flex-col md:flex-row overflow-auto rounded-t-lg shadow-inner">
        <span onclick="moduleMenuToggle()" class="text-{{$data->ref->template->primaryColor}}-500 border border-{{$data->ref->template->primaryColor}}-500 text-center mt-2 font-bold tracking-wide uppercase cursor-pointer p-4 rounded md:hidden">
            Menu
        </span>

        @foreach ($data->categories as $category)
            @if ($loop->first) @continue @endif
            <a href="{{ $category->url }}" class="menu-mod-item whitespace-no-wrap px-6 tracking-wide shadow-inner pt-3 pb-4 text-{{$data->ref->template->primaryColor}}-500 hover:bg-{{$data->ref->template->primaryColor}}-600 hover:text-{{$data->ref->template->primaryColor}}-100 text-lg hidden md:block">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

</nav>

@push('pre-scripts')
<script>
    const items = document.getElementsByClassName('menu-mod-item')
    function moduleMenuToggle() {
        for(let i = 0; i < items.length; i++) {
            let item = items[i]
            item.classList.toggle('hidden')
        }
    }
</script>
@endpush