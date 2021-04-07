@extends('layout')

@section('title', __('admin/api_keys.show.title', ['api_key.name' => $apiKey->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.api_keys.index') }}">@lang('admin/api_keys.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.api_keys.show', $apiKey) }}">{{ $apiKey->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $apiKey->name }}</h1>
        <p><code>{{ $apiKey->key }}</code></p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.api_keys.edit', $apiKey) }}">@lang('admin/api_keys.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.api_keys.delete', $apiKey) }}">@lang('admin/api_keys.show.delete')</a>
        </div>
    </div>
@endsection
