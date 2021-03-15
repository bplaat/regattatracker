@extends('layout')

@section('title', __('offline.title'))

@section('navbar')
    <div class="navbar is-light is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">RegattaTracker</a>
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
