@extends('active.master')

@section('metadesc'){{ $data->ref->site->desc }}@endsection

@push('styles')
<style>
    .pattern {
        background-color: #fefefe;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 28' width='56' height='28'%3E%3Cpath fill='{{ $data->ref->template->primaryColor }}' fill-opacity='0.09' d='M56 26v2h-7.75c2.3-1.27 4.94-2 7.75-2zm-26 2a2 2 0 1 0-4 0h-4.09A25.98 25.98 0 0 0 0 16v-2c.67 0 1.34.02 2 .07V14a2 2 0 0 0-2-2v-2a4 4 0 0 1 3.98 3.6 28.09 28.09 0 0 1 2.8-3.86A8 8 0 0 0 0 6V4a9.99 9.99 0 0 1 8.17 4.23c.94-.95 1.96-1.83 3.03-2.63A13.98 13.98 0 0 0 0 0h7.75c2 1.1 3.73 2.63 5.1 4.45 1.12-.72 2.3-1.37 3.53-1.93A20.1 20.1 0 0 0 14.28 0h2.7c.45.56.88 1.14 1.29 1.74 1.3-.48 2.63-.87 4-1.15-.11-.2-.23-.4-.36-.59H26v.07a28.4 28.4 0 0 1 4 0V0h4.09l-.37.59c1.38.28 2.72.67 4.01 1.15.4-.6.84-1.18 1.3-1.74h2.69a20.1 20.1 0 0 0-2.1 2.52c1.23.56 2.41 1.2 3.54 1.93A16.08 16.08 0 0 1 48.25 0H56c-4.58 0-8.65 2.2-11.2 5.6 1.07.8 2.09 1.68 3.03 2.63A9.99 9.99 0 0 1 56 4v2a8 8 0 0 0-6.77 3.74c1.03 1.2 1.97 2.5 2.79 3.86A4 4 0 0 1 56 10v2a2 2 0 0 0-2 2.07 28.4 28.4 0 0 1 2-.07v2c-9.2 0-17.3 4.78-21.91 12H30zM7.75 28H0v-2c2.81 0 5.46.73 7.75 2zM56 20v2c-5.6 0-10.65 2.3-14.28 6h-2.7c4.04-4.89 10.15-8 16.98-8zm-39.03 8h-2.69C10.65 24.3 5.6 22 0 22v-2c6.83 0 12.94 3.11 16.97 8zm15.01-.4a28.09 28.09 0 0 1 2.8-3.86 8 8 0 0 0-13.55 0c1.03 1.2 1.97 2.5 2.79 3.86a4 4 0 0 1 7.96 0zm14.29-11.86c1.3-.48 2.63-.87 4-1.15a25.99 25.99 0 0 0-44.55 0c1.38.28 2.72.67 4.01 1.15a21.98 21.98 0 0 1 36.54 0zm-5.43 2.71c1.13-.72 2.3-1.37 3.54-1.93a19.98 19.98 0 0 0-32.76 0c1.23.56 2.41 1.2 3.54 1.93a15.98 15.98 0 0 1 25.68 0zm-4.67 3.78c.94-.95 1.96-1.83 3.03-2.63a13.98 13.98 0 0 0-22.4 0c1.07.8 2.09 1.68 3.03 2.63a9.99 9.99 0 0 1 16.34 0z'%3E%3C/path%3E%3C/svg%3E");
    }
</style>
@endpush

@section('contents')

    <div class="w-full max-w-6xl mx-auto px-6 font-reading">

        <div class="w-full flex items-center justify-between py-4">
            <a href="/" class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current text-{{$data->ref->template->primaryColor}}-600 inline-block fill-current h-12 w-12" viewBox="0 0 512 512"><path d="M147 286a10 10 0 100 20 10 10 0 000-20zM147 326c-6 0-10 4-10 10v126a10 10 0 1020 0V336c0-6-5-10-10-10z"/><path d="M424 8a10 10 0 00-15-6c-10 7-61 45-69 67-5 14-4 28 3 41-12 17-25 42-36 65V10c0-6-5-10-10-10h-80c-6 0-10 4-10 10v196h-2l-17-66v-1l-16-57v-1-1l-1-1a10 10 0 00-1-1L111 8a10 10 0 00-17 4l-18 91-1 1a10 10 0 001 2v1l15 58 11 41a30 30 0 00-25 30c0 13 8 24 20 28v198c0 28 22 50 50 50h200c27 0 50-22 50-50V264a30 30 0 0020-28c0-15-11-27-25-29 7-27 12-53 13-74 14-5 24-16 29-29 8-23-7-84-10-96zm-68 118a50 50 0 0029 10c-2 20-7 45-13 70h-57c15-35 29-62 41-80zM227 20h60v23h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v20h-20a10 10 0 000 20h20v23h-60V20zM109 36l41 49a46 46 0 01-53 14l12-63zm-9 85a66 66 0 0058-16l11 40 15 61h-62l-11-46-11-39zm277 341c0 17-14 30-30 30H147c-17 0-30-13-30-30V266h260v196zm20-226a10 10 0 01-10 10H107a10 10 0 010-20h280c5 0 10 4 10 10zm18-139a30 30 0 01-52 7c-6-8-7-18-4-28 4-10 28-32 49-49 6 27 11 59 7 70z"/></svg>
                <span class="pl-2 cursor-pointer font-heading text-2xl md:text-3xl font-bold text-{{$data->ref->template->primaryColor}}-600 opacity-75">{{ $data->ref->site->name }}</span>

            </a>

            @include('active.user-menu')

        </div>

        <div class="w-full mt-4">
            <nav>
                <div class="flex flex-no-wrap flex-col md:flex-row overflow-auto rounded-t-lg shadow-inner">
                    <span onclick="moduleMenuToggle()" class="text-{{$data->ref->template->primaryColor}}-500 border border-{{$data->ref->template->primaryColor}}-500 text-center mt-2 font-bold tracking-wide uppercase cursor-pointer p-4 rounded md:hidden">
                        Menu
                    </span>

                    @foreach ($data->topics as $topic)
                        @if ($loop->first) @continue @endif
                        <a href="{{ $topic->url }}" class="menu-mod-item whitespace-no-wrap px-6 tracking-wide shadow-inner pt-3 pb-4 hover:bg-{{$data->ref->template->primaryColor}}-600 hover:text-{{$data->ref->template->primaryColor}}-100 text-lg hidden md:block">
                            {{ $topic->name }}
                        </a>
                    @endforeach
                </div>
            </nav>
        </div>


        <div class="border-t-4 border-{{$data->ref->template->primaryColor}}-500 w-full pattern rounded-b-lg px-10 py-8 overflow-scroll md:flex justify-center md:justify-between items-center">
            <div class="w-full md:w-1/3 max-w-lg flex justify-center md:justify-start">
                @if(! empty($data->pages[0]->media))
                <img src="{{$data->pages[0]->media->url}}" class="shadow-lg rounded-lg">
                @else
                <img src="https://source.unsplash.com/400x300?abstract,{{$data->ref->template->primaryColor}}" class="shadow-lg rounded-lg">
                @endif
            </div>
            <div class="w-full md:w-2/3 max-w-4xl px-0 md:px-8">
                <div class="mb-2 text-gray-600 px-2 mt-4 md:mt-0">Latest Post</div>
                <h3 class="text-4xl text-gray-700 font-heading font-bold italic leading-tight">{{ $data->pages[0]->title }}</h3>
                <p class="py-4 text-lg text-gray-700">{{ $data->pages[0]->summary }}</p>
                <a href="{{ $data->pages[0]->url }}" class=" inline-block mt-4 text-{{$data->ref->template->primaryColor}}-600 p-3 border-2 rounded border-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-600 hover:text-{{$data->ref->template->primaryColor}}-100 font-bold">Continue Reading...</a>
            </div>
        </div>

        <div class="md:flex md:flex-wrap">

                @foreach ($data->pages as $page)

                @if ($loop->first) @continue @endif

                <section class="w-full md:w-1/2 p-4">

                    <header>
                        <h2 class="my-2 font-heading text-3xl">
                            <a href="{{ $page->url }}" class="text-gray-700 leading-tight hover:text-{{$data->ref->template->primaryColor}}-500">
                                {{ $page->title }}
                            </a>
                        </h2>
                    </header>
                    <div class="text-gray-800">
                        {{ $page->summary }}
                    </div>
                    <footer>
                        <div class="text-sm mt-3">
                            Published {{ $page->created_ago }} under <a href="{{ $page->category->url }}" class="text-{{$data->ref->template->primaryColor}}-600 p-1 hover:text-{{$data->ref->template->primaryColor}}-800 font-semibold">{{ $page->category->name }}</a>
                        </div>
                    </footer>
                </section>

                @endforeach

        </div>
        <div class="w-full flex justify-center mt-6 p-4 border-t text-gray-400 rounded-lg">
                &copy; <?php echo date('Y') ?> - All Rights Reserved. Made with&nbsp;<a href="https://webtheory.co">WebTheory</a>
        </div>
    </div>

@endsection

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