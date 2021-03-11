@extends('layout')

@section('title', __('admin/buoys.edit.title', [ 'buoy.name' => $buoy->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.edit', $buoy) }}">@lang('admin/buoys.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/buoys.edit.header')</h1>

    <form method="POST" action="{{ route('admin.buoys.update', $buoy) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/buoys.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $buoy->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('admin/buoys.edit.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description">{{ old('description', $buoy->description) }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/buoys.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
