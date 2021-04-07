@extends('layout')

@section('title', __('admin/api_keys.edit.title', ['api_key.name' => $apiKey->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.api_keys.index') }}">@lang('admin/api_keys.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.api_keys.show', $apiKey) }}">{{ $apiKey->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.api_keys.edit', $apiKey) }}">@lang('admin/api_keys.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/api_keys.edit.header')</h1>

    <form method="POST" action="{{ route('admin.api_keys.update', $apiKey) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/api_keys.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $apiKey->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="key">@lang('admin/api_keys.edit.key')</label>

            <div class="control">
                <input class="input" type="text" id="key" name="key" value="{{ $apiKey->key }}" disabled required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/api_keys.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
