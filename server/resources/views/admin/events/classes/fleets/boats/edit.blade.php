@extends('layout')

@section('title', __('admin/events.classes.fleets.boats.edit.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name, 'boat.name' => $boat->name]))

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
            <li><a href="{{ route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]) }}">@lang('admin/events.classes.fleets.boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.boats.edit', [$event, $eventClass, $eventClassFleet, $boat]) }}">@lang('admin/events.classes.fleets.boats.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.fleets.boats.edit.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.fleets.boats.update', [$event, $eventClass, $eventClassFleet, $boat]) }}">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="started_at_date">@lang('admin/events.classes.fleets.boats.edit.started_at_date')</label>

                    <div class="control">
                        <input class="input @error('started_at_date') is-danger @enderror" type="date" id="started_at_date" name="started_at_date" value="{{ old('started_at_date', $eventClassFleetBoat->started_at != null ? $eventClassFleetBoat->started_at->format('Y-m-d') : '') }}">
                    </div>

                    @error('started_at_date')
                        <p class="help is-danger">{{ $errors->first('started_at_date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="started_at_time">@lang('admin/events.classes.fleets.boats.edit.started_at_time')</label>

                    <div class="control">
                        <input class="input @error('started_at_time') is-danger @enderror" type="time" step="1" id="started_at_time" name="started_at_time" value="{{ old('started_at_time', $eventClassFleetBoat->started_at != null ? $eventClassFleetBoat->started_at->format('H:i:s') : '') }}">
                    </div>

                    @error('started_at_time')
                        <p class="help is-danger">{{ $errors->first('started_at_time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="finished_at_date">@lang('admin/events.classes.fleets.boats.edit.finished_at_date')</label>

                    <div class="control">
                        <input class="input @error('finished_at_date') is-danger @enderror" type="date" id="finished_at_date" name="finished_at_date" value="{{ old('finished_at_date', $eventClassFleetBoat->finished_at != null ? $eventClassFleetBoat->finished_at->format('Y-m-d') : '') }}">
                    </div>

                    @error('finished_at_date')
                        <p class="help is-danger">{{ $errors->first('finished_at_date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="finished_at_time">@lang('admin/events.classes.fleets.boats.edit.finished_at_time')</label>

                    <div class="control">
                        <input class="input @error('finished_at_time') is-danger @enderror" type="time" step="1" id="finished_at_time" name="finished_at_time" value="{{ old('finished_at_time', $eventClassFleetBoat->finished_at != null ? $eventClassFleetBoat->finished_at->format('H:i:s') : '') }}">
                    </div>

                    @error('finished_at_time')
                        <p class="help is-danger">{{ $errors->first('finished_at_time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
