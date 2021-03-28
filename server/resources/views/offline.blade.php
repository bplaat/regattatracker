@extends('layout')

@section('title', __('offline.title'))

@section('navbar')
    <div class="navbar is-light is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; margin-right: 10px;" viewBox="0 0 24 24">
                        <path fill="#111" d="M7,17L10.2,10.2L17,7L13.8,13.8L7,17M12,11.1A0.9,0.9 0 0,0 11.1,12A0.9,0.9 0 0,0 12,12.9A0.9,0.9 0 0,0 12.9,12A0.9,0.9 0 0,0 12,11.1M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z" />
                    </svg>
                    {{ config('app.name') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="content">
        <h1 class="title">@lang('offline.title')</h1>
        <p>@lang('offline.description')</p>
    </div>
@endsection
