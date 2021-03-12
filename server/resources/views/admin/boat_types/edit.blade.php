@extends('layout')

@section('title', __('admin/boat_types.edit.title', ['boat_type.name' => $boatType->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.edit', $boatType) }}">@lang('admin/boat_types.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/boat_types.edit.header')</h1>

    <form method="POST" action="{{ route('admin.boat_types.update', $boatType) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/boat_types.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $boatType->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('admin/boat_types.edit.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description">{{ old('description', $boatType->description) }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/boat_types.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
