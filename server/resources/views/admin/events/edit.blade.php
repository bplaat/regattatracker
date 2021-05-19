@extends('layout')

@section('title', __('admin/events.edit.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.edit', $event) }}">@lang('admin/events.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.edit.header')</h1>

    <form method="POST" action="{{ route('admin.events.update', $event) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/events.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name"
                       value="{{ old('name', $event->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <label class="label" for="start_date">@lang('admin/events.edit.start')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('start_date') is-danger @enderror" type="date" id="start_date"
                               name="start_date"
                               value="{{ old('start_date', $event->start == null ? '' : date('Y-m-d', strtotime($event->start))) }}">
                    </div>

                    @error('start_date')
                        <p class="help is-danger">{{ $errors->first('start_date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <label class="label" for="end_date">@lang('admin/events.edit.end')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('end_date') is-danger @enderror" type="date" id="end_date"
                               name="end_date"
                               value="{{ old('end_date', $event->end == null ? '' : date('Y-m-d', strtotime($event->end))) }}">
                    </div>

                    @error('end_date')
                        <p class="help is-danger">{{ $errors->first('end_date') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
