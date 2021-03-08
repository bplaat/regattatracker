@extends('layout')

@section('title', __('errors/404.title'))

@section('content')
    <div class="content">
        <h1 class="title">@lang('errors/404.title')</h1>
        <p>@lang('errors/404.description_first', [ 'url' => $_SERVER['REQUEST_URI'] ])</p>
        <p>@lang('errors/404.description_second')</p>
    </div>
@endsection
