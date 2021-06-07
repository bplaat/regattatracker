@extends('layout')

@section('title', __('admin/events.classes.fleets.boats.users.index.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name, 'boat.name' => $boat->name]))

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
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]) }}">@lang('admin/events.classes.fleets.boats.users.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/events.classes.fleets.boats.users.index.header')</h1>

        <div class="columns">
            <div class="column"></div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/events.classes.fleets.boats.users.index.query_placeholder')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.users.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        <h2 class="subtitle">@lang('admin/events.classes.fleets.boats.users.index.user_header')</h2>

        @if ($boatUsers->count() > 0)
            {{ $boatUsers->links() }}

            <div class="columns is-multiline">
                @foreach ($boatUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></h3>

                            <div class="buttons">
                                <a class="button is-danger is-light is-small" href="{{ route('admin.events.classes.fleets.boats.users.delete', [$event, $eventClass, $eventClassFleet, $boat, $user]) }}">
                                    @lang('admin/events.classes.fleets.boats.users.index.user_delete_button')
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatUsers->links() }}
        @else
            <p><i>@lang('admin/events.classes.fleets.boats.users.index.empty')</i></p>
        @endif

        @if ($eventClassFleetBoat->users->count() != $users->count())
            <form method="POST" action="{{ route('admin.events.classes.fleets.boats.users.store', [$event, $eventClass, $eventClassFleet, $boat]) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('user_id') is-danger @enderror">
                            <select id="user_id" name="user_id" required>
                                <option selected disabled>
                                    @lang('admin/events.classes.fleets.boats.users.index.user_placeholder')
                                </option>

                                @foreach ($users as $user)
                                    @if (!$boatUsers->pluck('id')->contains($user->id))
                                        <option value="{{ $user->id }}" @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.users.index.user_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
