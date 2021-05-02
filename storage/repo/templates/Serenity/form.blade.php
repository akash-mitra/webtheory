@extends('active.master')

@section('title'){{ $data->form->name  }}@endsection

@section('metadesc'){{ $data->form->description  }}@endsection

@section('metakeys'){{ $data->form->name }}@endsection

@push('headers')

    <link rel="canonical" href="{{ $data->form->permalink }}">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="{{ $data->ref->site->name }}">
    <meta property="og:title" content="{{ $data->form->name }}">
    <meta property="og:description" content="{{ $data->form->description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <!--meta property="fb:app_id" content=""-->

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $data->form->name }}" />
    <meta name="twitter:description" content="{{ $data->form->description  }}" />
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
            @form(['id' => $data->form->id])
        </main>

    </div>

@endsection
