@extends('layout')

@section('title', __('admin/events.classes.fleets.boats.index.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name]))

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
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]) }}">@lang('admin/events.classes.fleets.boats.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/events.classes.fleets.boats.index.header')</h1>

        <div class="columns">
            <div class="column"></div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/events.classes.fleets.boats.index.query_placeholder')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($eventClassFleetBoats->count() > 0)
            {{ $eventClassFleetBoats->links() }}

            <div class="columns is-multiline">
                @foreach ($eventClassFleetBoats as $eventClassFleetBoat)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title"><a href="{{ route('admin.boats.show', $eventClassFleetBoat) }}">{{ $eventClassFleetBoat->name }}</a></h2>

                            @if ($eventClassFleetBoat->pivot->started_at != null)
                                <p>@lang('admin/events.classes.fleets.boats.index.boat_started_at') {{ $eventClassFleetBoat->pivot->started_at->format('Y-m-d H:i:s') }}</p>
                            @else
                                <p><i>@lang('admin/events.classes.fleets.boats.index.boat_started_at_empty')</i></p>
                            @endif

                            @if ($eventClassFleetBoat->pivot->finished_at != null)
                                <p>@lang('admin/events.classes.fleets.boats.index.boat_finished_at') {{ $eventClassFleetBoat->pivot->finished_at->format('Y-m-d H:i:s') }}</p>
                            @else
                                <p><i>@lang('admin/events.classes.fleets.boats.index.boat_finished_at_empty')</i></p>
                            @endif

                            <div class="buttons">
                                <a class="button is-link is-light is-small" href="{{ route('admin.events.classes.fleets.boats.edit', [$event, $eventClass, $eventClassFleet, $eventClassFleetBoat]) }}">
                                    @lang('admin/events.classes.fleets.boats.index.boat_edit_button')
                                </a>
                                <a class="button is-danger is-light is-small" href="{{ route('admin.events.classes.fleets.boats.delete', [$event, $eventClass, $eventClassFleet, $eventClassFleetBoat]) }}">
                                    @lang('admin/events.classes.fleets.boats.index.boat_delete_button')
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $eventClassFleetBoats->links() }}
        @else
            <p><i>@lang('admin/events.classes.fleets.boats.index.empty')</i></p>
        @endif

        @if ($eventClassFleet->boats->count() != $boats->count())
            <form method="POST" action="{{ route('admin.events.classes.fleets.boats.store', [$event, $eventClass, $eventClassFleet]) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('boat_id') is-danger @enderror">
                            <select id="boat_id" name="boat_id" required>
                                <option selected disabled>
                                    @lang('admin/events.classes.fleets.boats.index.boat_placeholder')
                                </option>

                                @foreach ($boats as $boat)
                                    @if (!$eventClassFleetBoats->pluck('id')->contains($boat->id))
                                        <option value="{{ $boat->id }}" @if ($boat->id == old('boat_id')) selected @endif>
                                            {{ $boat->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.index.boat_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
