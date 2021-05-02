@extends('active.master')

@section('title'){{ $data->page->title  }}@endsection

@section('metadesc'){{ $data->page->metadesc  }}@endsection

@section('metakeys'){{ $data->page->metakey }}@endsection

@push('headers')

    <link rel="canonical" href="{{ $data->page->permalink }}">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ $data->ref->site->name }}">
    <meta property="og:title" content="{{ $data->page->title }}">
    <meta property="og:description" content="{{ $data->page->summary }}">
    <meta property="og:image" content="{{ optional($data->page->media)->url }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <!--meta property="fb:app_id" content=""-->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data->page->title }}" />
    <meta name="twitter:description" content="{{ $data->page->summary  }}" />
    <meta name="twitter:image" content="{{ optional($data->page->media)->url }}" />
    <meta name="twitter:domain" content="{{ env('DOMAIN') }}">

@endpush

@section('contents')

    <div class="w-full h-1 bg-{{$data->ref->template->primaryColor}}-600 fixed top-0 shadow-lg"></div>

    <div class="w-full max-w-6xl mx-auto px-6 md:px-8">

        <div class="w-full flex items-center justify-between pb-8 pt-10 border-b">
            <x-logo class="flex items-center"
                    logo-text="{{ $data->ref->site->name }}"
                    logo-file="{{ $data->ref->site->logo }}"
                    color="{{ $data->ref->template->primaryColor }}">
            </x-logo>

            @include('active.user-menu')

        </div>


        <main class="w-full max-w-3xl @if($data->ref->template->centerContent === 'yes') mx-auto @endif py-10 px-6 text-gray-800">
            <article class="wt-typography">
                <header>
                    <a href="{{ $data->page->category->url }}" class="text-blue-400">
                        {{ $data->page->category->name }}
                    </a>
                    <h1 class="text-gray-800 text-4xl font-serif">{{ $data->page->title }}</h1>
                    <div class="w-full flex items-center mt-6 mb-8 text-sm">
                        <a href="{{ $data->page->author->url }}">
                        <img src="{{ $data->page->author->avatar }}" class="h-12 w-12 border-2 rounded-full" />
                        </a>
                        <div class="ml-4">
                            <div class="w-full">
                                <a href="{{ $data->page->author->url }}" class="hover:text-{{$data->ref->template->primaryColor}}-600">
                                    {{ $data->page->author->name }}
                                </a>
                            </div>
                            <div class="w-full flex items-center">
                                <span>Updated on {{ $data->page->updated_at->format('M d, Y') }}</span>
                                <span class="ml-3 px-2 bg-gray-200">@readtime</span>
                            </div>
                        </div>
                    </div>

                    <p class="mb-3 wt-summary bg-{{$data->ref->template->primaryColor}}-100">{{ $data->page->summary }}</p>

                    <div class="flex">
                        @sharepost
                    </div>
                </header>

                @foreach($data->page->contents as $content)
                <div class="mt-2 text-base wt-body">
                    {!! $content->body_html !!}
                </div>
                @endforeach
            </article>

            @comments

            @ads

        </main>

    </div>

@endsection
