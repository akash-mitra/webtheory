@extends('default.layout')

@section('top')
    <div class='site-logo'>
        <a href='/'>
            <img src='{{ $api->site()->logo() }}' class='site-logo-img' alt='Go to Home'/>
        </a>
        <div class='site-logo-caption'>{{ $api->site()->title() }}</div>
    </div>
    <div class='site-login'>
        <x-modal>
            <x-slot name='trigger'>
                <button type='button'>Login</button>
            </x-slot>

            <x-login-form></x-login-form>
        </x-modal>

    </div>
@endsection

@section('contents')
    {!! $api->html() !!}
@endsection
