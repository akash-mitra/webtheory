@extends('active.master')

@section('title'){{ $data->category->name }}@endsection

@section('metadesc'){{ $data->category->name . ' -' . $data->ref->site->title  }}@endsection

@section('metakeys'){{ $data->category->metakey }}@endsection

@push('headers')

<link rel="canonical" href="{{ $data->category->permalink }}">

<meta property="og:title" content="{{ $data->category->name }}">
<meta property="og:description" content="{{ $data->category->description }}">
<meta property="og:image" content="{{ url('/') . optional($data->category->media)->url }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta property="og:site_name" content="{{ $data->ref->site->name }}">

@endpush

@section('contents')



    <div class="w-full max-w-6xl mx-auto px-6 md:px-8">

        <div class="w-full flex items-center justify-between pb-8 pt-10">
            <x-logo class="flex items-center"
                    logo-text="{{ $data->ref->site->name }}"
                    logo-file="{{ $data->ref->site->logo }}"
                    color="{{ $data->ref->template->primaryColor }}">
            </x-logo>

            @include('active.user-menu')

        </div>


        <main class="w-full max-w-6xl mx-auto pb-10 px-6 text-gray-800">
            <header>
                @if(! empty($data->category->parent))
                    <a class="py-1 text-{{$data->ref->template->primaryColor}}-400" href="{{ $data->category->parent->url }}">{{ $data->category->parent->name }}</a>
                @endif
                <h1 class="text-4xl text-{{$data->ref->template->primaryColor}}-500">{{ $data->category->name }}</h1>
                @if(empty($data->category->media))
                    <div class="w-full bordeqr-b">&nbsp;</div>
                @else
                    <img src="{{ $data->category->media->url }}" class="w-full mt-2 shadown">
                @endif
                <p class="mt-2 py-4 text-xl text-{{$data->ref->template->primaryColor}}-100">{{ $data->category->description }}</p>
                <div class="w-full flex">
                    <div class="bg-{{$data->ref->template->primaryColor}}-200 rounded-lg py-2 px-4 mr-3"><b>{{ count($data->category->pages) }}</b> Articles</div>
                    <div class="bg-{{$data->ref->template->primaryColor}}-200 rounded-lg py-2 px-4 mr-3"><b>{{ count($data->category->subcategories) }}</b> Sub-categories</div>
                </div>
            </header>

            <section>
                <header class="mt-8 text-2xl text-{{$data->ref->template->primaryColor}}-700 border-b py-2">Articles</header>

                <div class="w-full md:flex md:justify-between md:flex-wrap text-{{$data->ref->template->primaryColor}}-100">
                @if(count($data->category->pages)===0)
                    <p class="mt-3 p-4">No article under this category</p>
                @endif
                @foreach($data->category->pages as $page)
                    <div class="w-full md:w-1/2 p-6 mb-2">

                        <h2 class="my-2 text-2xl">
                            <a href="{{ $page->url }}" class="text-{{$data->ref->template->primaryColor}}-500 leading-tight hover:text-{{$data->ref->template->primaryColor}}-500">
                                {{ $page->title }}
                            </a>
                        </h2>
                        <p class="text-{{$data->ref->template->primaryColor}}-100 mt-3">{{ $page->summary }}</p>
                        <p class="text-xs text-{{$data->ref->template->primaryColor}}-200 py-2">Updated {{ $page->updated_at->format('d M, Y')}}</p>
                        <a class="mt-3 inline-block text-{{$data->ref->template->primaryColor}}-600" href="{{$page->url}}">Read More</a>
                    </div>
                @endforeach
            </section>

            <section>
                <header class="mt-8 text-2xl text-{{$data->ref->template->primaryColor}}-100 border-b py-2">Sub-categories</header>

                <div class="w-full md:flex md:justify-between md:flex-wrap">
                @if(count($data->category->subcategories)===0)
                    <p class="text-{{$data->ref->template->primaryColor}}-100 mt-3 p-4">No sub-category under this category</p>
                @endif
                @foreach($data->category->subcategories as $category)
                    <div class="w-full md:w-1/2 p-6 mb-2">

                        <h2 class="my-2 text-2xl">
                            <a href="{{ $category->url }}" class="text-{{$data->ref->template->primaryColor}}-500 leading-tight hover:text-{{$data->ref->template->primaryColor}}-500">
                                {{ $category->name }}
                            </a>
                        </h2>
                        <p class="text-{{$data->ref->template->primaryColor}}-100 mt-3">{{ $category->description }}</p>
                        <a class="mt-3 inline-block text-{{$data->ref->template->primaryColor}}-600" href="{{$category->url}}">Explore</a>
                    </div>
                @endforeach
            </section>

            @comments
        </main>


    </div>

@endsection
