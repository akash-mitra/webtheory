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

    {{-- <div class="w-full h-1 bg-{{$data->ref->template->primaryColor}}-800 fixed top-0 shadow-lg"></div> --}}

    <div class="w-full px-6 md:px-8 border-b border-gray-800">

        <div class="w-full max-w-6xl mx-auto flex items-center justify-between pb-8 pt-10 ">
            <x-logo class="flex items-center"
                    logo-text="{{ $data->ref->site->name }}"
                    logo-file="{{ $data->ref->site->logo }}"
                    color="{{ $data->ref->template->primaryColor }}">
            </x-logo>

            @include('active.user-menu')

        </div>
    </div>
    <div class="w-full px-6 md:px-8">
        <main class="w-full max-w-3xl @if($data->ref->template->centerContent === 'yes') mx-auto @endif py-10 px-6 text-gray-400">
            <article class="wt-typography">
                <header>
                    <a href="{{ $data->page->category->url }}" class="text-{{$data->ref->template->primaryColor}}-500">
                        {{ $data->page->category->name }}
                    </a>
                    <h1 class="text-{{$data->ref->template->primaryColor}}-500 text-4xl font-serif">{{ $data->page->title }}</h1>
                    <div class="w-full flex items-center mt-6 mb-8 text-sm">
                        <a href="{{ $data->page->author->url }}">
                        <img src="{{ $data->page->author->avatar }}" class="h-12 w-12 rounded-full" />
                        </a>
                        <div class="ml-4">
                            <div class="w-full">
                                <a href="{{ $data->page->author->url }}" class="hover:text-{{$data->ref->template->primaryColor}}-600">
                                    {{ $data->page->author->name }}
                                </a>
                            </div>
                            <div class="w-full flex items-center">
                                <span>Updated on {{ $data->page->updated_at->format('M d, Y') }}</span>
                                <span class="ml-3 px-2 text-gray-400 bg-gray-800">@readtime</span>
                            </div>
                        </div>
                    </div>

                    <p class="mb-3 wt-summary bg-{{$data->ref->template->primaryColor}}-900">{{ $data->page->summary }}</p>

                    <div class="flex">
                        @sharepost
                    </div>
                </header>

                @foreach($data->page->contents as $content)
                <div class="mt-2 text-base wt-body text-{{$data->ref->template->primaryColor}}-100">
                    {!! $content->body_html !!}
                </div>
                @endforeach

            </article>

            @comments([
                'boxClass' => 'w-full flex p-4 rounded-lg mb-2 pb-6 bg-gray-900',
                'textBoxClass' => 'mt-2 rounded-lg p-2 w-full h-12 bg-gray-800 text-gray-400',
                'buttonClass' => 'ml-3 bg-blue-600 text-white py-1 px-4 rounded hover:bg-blue-800',
                'linkClass' => 'font-bold text-blue-600',
                'commentClass' => 'text-gray-500',
                'textClass' => 'text-gray-600',
                'replyTextClass' => 'hover:text-blue-500',
                'commentInviteClass' => 'w-full flex p-4 bg-gray-800 rounded-lg mb-4 justify-between items-center',
            ])

            @ads

        </main>

    </div>

@endsection
