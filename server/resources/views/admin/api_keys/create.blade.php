@extends('layout')

@section('title', __('admin/api_keys.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.api_keys.index') }}">@lang('admin/api_keys.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.api_keys.create') }}">@lang('admin/api_keys.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/api_keys.create.header')</h1>

    <form method="POST" action="{{ route('admin.api_keys.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/api_keys.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/api_keys.create.button')</button>
            </div>
        </div>
    </form>
@endsection
