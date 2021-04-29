@extends('layout')

@section('title', __('admin/finishes.edit.title', ['event.name' => $event->name, 'finish.name' => __('admin/finishes.show.breadcrumb') . ' #' . $finish->id]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/finishes.edit.breadcrumb') #{{ $finish->id }}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.finishes.edit', [$event, $finish]) }}">@lang('admin/finishes.edit.breadcrumb')</a>
            </li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/finishes.edit.header')</h1>
    <form method="POST" action="{{ route('admin.events.finishes.update', [$event, $finish]) }}">
        @csrf

        <p>@lang('admin/finishes.edit.point_a')</p>
        <div class="field has-addons">
            <div class="control">
                <input class="input @error('latitude_a') is-danger @enderror" type="text" id="latitude_a"
                       name="latitude_a"
                       placeholder="@lang('admin/finishes.edit.latitude_a_field')"
                       value="{{ old('latitude_a', $finish->latitude_a) }}" required>
            </div>

            <div class="control">
                <input class="input @error('longitude_a') is-danger @enderror" type="text" id="longitude_a"
                       name="longitude_a"
                       placeholder="@lang('admin/finishes.edit.longitude_a_field')"
                       value="{{ old('longitude_a', $finish->longitude_a) }}" required>
            </div>
        </div>
        <p>@lang('admin/finishes.edit.point_b')</p>
        <div class="field has-addons">
            <div class="control">
                <input class="input @error('latitude_b') is-danger @enderror" type="text" id="latitude_b"
                       name="latitude_b"
                       placeholder="@lang('admin/finishes.edit.latitude_b_field')"
                       value="{{ old('latitude_b', $finish->latitude_b) }}" required>
            </div>

            <div class="control">
                <input class="input @error('longitude_b') is-danger @enderror" type="text" id="longitude_b"
                       name="longitude_b"
                       placeholder="@lang('admin/finishes.edit.longitude_b_field')"
                       value="{{ old('longitude_b', $finish->longitude_b) }}" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link"
                        type="submit">@lang('admin/finishes.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
