@extends('layout')

@section('title', __('admin/events.finishes.create.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.finishes.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.finishes.create', $event) }}">@lang('admin/events.finishes.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.finishes.create.header')</h1>

    <form method="POST" action="{{ route('admin.events.finishes.store', $event) }}">
        @csrf

        <div class="columns">
            <div class="column">
                <label class="label" for="latitude_a">@lang('admin/events.finishes.create.latitude_a')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('latitude_a') is-danger @enderror" type="text" id="latitude_a"
                            name="latitude_a" value="{{ old('latitude_a') }}" required>
                    </div>

                    @error('latitude_a')
                        <p class="help is-danger">{{ $errors->first('latitude_a') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <label class="label" for="longitude_a">@lang('admin/events.finishes.create.longitude_a')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('longitude_a') is-danger @enderror" type="text" id="longitude_a"
                            name="longitude_a" value="{{ old('longitude_a') }}" required>
                    </div>

                    @error('longitude_a')
                        <p class="help is-danger">{{ $errors->first('longitude_a') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <label class="label" for="latitude_b">@lang('admin/events.finishes.create.latitude_b')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('latitude_b') is-danger @enderror" type="text" id="latitude_b"
                            name="latitude_b" value="{{ old('latitude_b') }}" required>
                    </div>

                    @error('latitude_b')
                        <p class="help is-danger">{{ $errors->first('latitude_b') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <label class="label" for="longitude_b">@lang('admin/events.finishes.create.longitude_b')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('longitude_b') is-danger @enderror" type="text" id="longitude_b"
                            name="longitude_b" value="{{ old('longitude_b') }}" required>
                    </div>

                    @error('longitude_b')
                        <p class="help is-danger">{{ $errors->first('longitude_b') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.finishes.create.create_button')</button>
            </div>
        </div>
    </form>
@endsection
