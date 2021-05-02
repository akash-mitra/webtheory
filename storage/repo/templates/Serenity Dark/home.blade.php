@extends('active.master')

@section('title'){{ $data->ref->site->name }}@endsection

@section('metadesc'){{ $data->ref->site->desc }}@endsection

@push('headers')

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="{{ $data->ref->site->name }}">
    <meta property="og:title" content="{{ $data->ref->site->title }}">
    <meta property="og:description" content="{{ $data->ref->site->desc }}">
    @isset($data->ref->site->logo)
        <meta property="og:image" content="{{ $data->ref->site->logo }}">
    @endisset
    <meta property="og:url" content="{{ url('/') }}">
    <!--meta property="fb:app_id" content=""-->

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $data->ref->site->title }}" />
    <meta name="twitter:description" content="{{ $data->ref->site->desc  }}" />
    @isset($data->ref->site->logo)
        <meta name="twitter:image" content="{{ $data->ref->site->logo }}" />
    @endisset
    <meta name="twitter:domain" content="{{ env('DOMAIN') }}">

@endpush

@push('styles')
<style>
    .pattern {
        background-color: transparent;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 56 28' width='56' height='28'%3E%3Cpath fill='{{ $data->ref->template->primaryColor }}' fill-opacity='0.09' d='M56 26v2h-7.75c2.3-1.27 4.94-2 7.75-2zm-26 2a2 2 0 1 0-4 0h-4.09A25.98 25.98 0 0 0 0 16v-2c.67 0 1.34.02 2 .07V14a2 2 0 0 0-2-2v-2a4 4 0 0 1 3.98 3.6 28.09 28.09 0 0 1 2.8-3.86A8 8 0 0 0 0 6V4a9.99 9.99 0 0 1 8.17 4.23c.94-.95 1.96-1.83 3.03-2.63A13.98 13.98 0 0 0 0 0h7.75c2 1.1 3.73 2.63 5.1 4.45 1.12-.72 2.3-1.37 3.53-1.93A20.1 20.1 0 0 0 14.28 0h2.7c.45.56.88 1.14 1.29 1.74 1.3-.48 2.63-.87 4-1.15-.11-.2-.23-.4-.36-.59H26v.07a28.4 28.4 0 0 1 4 0V0h4.09l-.37.59c1.38.28 2.72.67 4.01 1.15.4-.6.84-1.18 1.3-1.74h2.69a20.1 20.1 0 0 0-2.1 2.52c1.23.56 2.41 1.2 3.54 1.93A16.08 16.08 0 0 1 48.25 0H56c-4.58 0-8.65 2.2-11.2 5.6 1.07.8 2.09 1.68 3.03 2.63A9.99 9.99 0 0 1 56 4v2a8 8 0 0 0-6.77 3.74c1.03 1.2 1.97 2.5 2.79 3.86A4 4 0 0 1 56 10v2a2 2 0 0 0-2 2.07 28.4 28.4 0 0 1 2-.07v2c-9.2 0-17.3 4.78-21.91 12H30zM7.75 28H0v-2c2.81 0 5.46.73 7.75 2zM56 20v2c-5.6 0-10.65 2.3-14.28 6h-2.7c4.04-4.89 10.15-8 16.98-8zm-39.03 8h-2.69C10.65 24.3 5.6 22 0 22v-2c6.83 0 12.94 3.11 16.97 8zm15.01-.4a28.09 28.09 0 0 1 2.8-3.86 8 8 0 0 0-13.55 0c1.03 1.2 1.97 2.5 2.79 3.86a4 4 0 0 1 7.96 0zm14.29-11.86c1.3-.48 2.63-.87 4-1.15a25.99 25.99 0 0 0-44.55 0c1.38.28 2.72.67 4.01 1.15a21.98 21.98 0 0 1 36.54 0zm-5.43 2.71c1.13-.72 2.3-1.37 3.54-1.93a19.98 19.98 0 0 0-32.76 0c1.23.56 2.41 1.2 3.54 1.93a15.98 15.98 0 0 1 25.68 0zm-4.67 3.78c.94-.95 1.96-1.83 3.03-2.63a13.98 13.98 0 0 0-22.4 0c1.07.8 2.09 1.68 3.03 2.63a9.99 9.99 0 0 1 16.34 0z'%3E%3C/path%3E%3C/svg%3E");
    }
</style>
@endpush



@section('contents')

    <div class="w-full max-w-6xl mx-auto px-6">

        <div class="w-full flex items-center justify-between py-4">
            <x-logo class="flex items-center"
                    logo-text="{{ $data->ref->site->name }}"
                    logo-file="{{ $data->ref->site->logo }}"
                    color="{{ $data->ref->template->primaryColor }}">
            </x-logo>

            @include('active.user-menu')

        </div>

        <div class="w-full mt-4">
            @menu
        </div>

        @if(count($data->pages) > 0)
        <div class="border-t-4 border-{{$data->ref->template->primaryColor}}-500 w-full pattern rounded-b-lg px-10 py-8 overflow-auto md:flex justify-center md:justify-between items-stretch">
            <div
                class="w-full md:w-1/3 max-w-lg bg-center bg-no-repeat bg-cover rounded"
                style="background-image: url('@if(! empty($data->pages[0]->media)){{$data->pages[0]->media->url}}@else https://source.unsplash.com/400x300?abstract,{{$data->ref->template->primaryColor}} @endif')">
            </div>
            <div class="w-full md:w-2/3 max-w-4xl px-0 md:px-8">
                <h3 class="text-4xl text-{{$data->ref->template->primaryColor}}-500 font-bold leading-tight">{{ $data->pages[0]->title }}</h3>
                <p class="py-4 text-lg text-{{$data->ref->template->primaryColor}}-200">{{ $data->pages[0]->summary }}</p>
                <a href="{{ $data->pages[0]->url }}" class=" inline-block mt-4 text-{{$data->ref->template->primaryColor}}-600 p-3 border-2 rounded border-{{$data->ref->template->primaryColor}}-600 hover:bg-{{$data->ref->template->primaryColor}}-600 hover:text-{{$data->ref->template->primaryColor}}-100 font-bold">Continue Reading...</a>
            </div>
        </div>
        @endif

        <div class="md:flex md:flex-wrap">

                @foreach ($data->pages as $page)

                @if ($loop->first) @continue @endif

                <section class="w-full md:w-1/2 p-4">

                    <header>
                        <h2 class="my-2 text-3xl">
                            <a href="{{ $page->url }}" class="text-{{$data->ref->template->primaryColor}}-500 leading-tight hover:text-{{$data->ref->template->primaryColor}}-500">
                                {{ $page->title }}
                            </a>
                        </h2>
                    </header>
                    <p class="text-{{$data->ref->template->primaryColor}}-100">
                        {{ $page->summary }}
                    </p>
                    <footer>
                        <div class="text-sm mt-3 text-{{$data->ref->template->primaryColor}}-100">
                            Published {{ $page->created_ago }} under <a href="{{ $page->category->url }}" class="text-{{$data->ref->template->primaryColor}}-500 p-1 hover:text-{{$data->ref->template->primaryColor}}-800 font-semibold">{{ $page->category->name }}</a>
                        </div>
                    </footer>
                </section>

                @endforeach

        </div>

    </div>

@endsection
