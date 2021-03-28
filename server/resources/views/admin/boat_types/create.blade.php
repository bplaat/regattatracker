@extends('layout')

@section('title', __('admin/boat_types.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.create') }}">@lang('admin/boat_types.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/boat_types.create.header')</h1>

    <form method="POST" action="{{ route('admin.boat_types.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/boat_types.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('admin/boat_types.create.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description">{{ old('description') }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/boat_types.create.button')</button>
            </div>
        </div>
    </form>
@endsection
