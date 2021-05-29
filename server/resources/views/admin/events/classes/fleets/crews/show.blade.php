@extends('layout')

@section('title', __('admin/events.classes.fleets.crews.show.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name]))

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
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.crews.show', [$event, $eventClass, $eventClassFleet]) }}">@lang('admin/events.classes.fleets.crews.show.breadcrumb')</a></li>
        </ul>
    </div>

    <!-- Event class fleet crews -->
    @if ($eventClassFleet->crews->count() > 0)
        <div class="box content">
            <h2 class="title is-spaced is-4">@lang('admin/events.show.classes_fleets_crews')</h2>

            @foreach ($eventClassFleet->crews as $eventClassFleetCrew)
                <div class="box content">
                    <h3 class="title is-spaced is-4">{{ $eventClassFleetCrew->name }}</h3>

                    <div class="buttons">
                        <a class="button is-link" href="{{ route('admin.events.classes.fleets.crews.edit', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet, 'eventClassFleetCrew' => $eventClassFleetCrew]) }}">
                            @lang('admin/events.show.classes_fleets_edit_button')
                        </a>
                        <a class="button is-danger" href="{{ route('admin.events.classes.fleets.crews.delete', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet, 'eventClassFleetCrew' => $eventClassFleetCrew]) }}">
                            @lang('admin/events.show.classes_fleets_crews_delete_button')
                        </a>
                    </div>
                </div>
            @endforeach

            <a class="button is-link"  href="{{ route('admin.events.classes.fleets.crews.create', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet]) }}">
                @lang('admin/events.show.classes_fleets_crews_create_button')
            </a>
        </div>
    @else
        <p><i>@lang('admin/events.show.classes_fleets_crews_empty')</i></p>

        <a class="button is-link" href="{{ route('admin.events.classes.fleets.crews.create', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet]) }}">
            @lang('admin/events.show.classes_fleets_crews_create_button')
        </a>
    @endif
@endsection
