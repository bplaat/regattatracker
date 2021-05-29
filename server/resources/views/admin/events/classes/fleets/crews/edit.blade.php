@extends('layout')

@section('title', __('admin/events.classes.fleets.edit.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClass->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.fleets.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClassFleet->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.fleets.crews.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClassFleetCrew->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.crews.edit', [$event, $eventClass, $eventClassFleet, $eventClassFleetCrew]) }}">@lang('admin/events.classes.fleets.crews.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.fleets.crews.edit.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.fleets.crews.update', [$event, $eventClass, $eventClassFleet, $eventClassFleetCrew]) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/events.classes.fleets.crews.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name"
                    name="name" value="{{ old('name', $eventClassFleetCrew->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.crews.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
