@extends('layout')

@section('title', __('admin/events.show.title', ['event.name' => $event->name]))

@section('head')
    <link rel="stylesheet" href="/css/mapbox-gl.min.css"/>
    <script src="/js/mapbox-gl.min.js"></script>
    <script src="/js/turf.min.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $event->name }}</h1>

        <h2 class="subtitle is-5">@lang('admin/events.show.date_info')</h2>
        @if ($event->start != null)
            <p>@lang('admin/events.show.start') {{ $event->start }}</p>
        @else
            <p><i>@lang('admin/events.show.start_empty')</i></p>
        @endif

        @if ($event->end != null)
            <p>@lang('admin/events.show.end') {{ $event->end }}</p>
        @else
            <p><i>@lang('admin/events.show.end_empty')</i></p>
        @endif

        <h2 class="subtitle is-5">@lang('admin/events.show.path_info')</h2>
        <p>
            @lang('admin/events.show.connected')
            @if ($event->connected == App\Models\Event::CONNECTED_TRUE)
                @lang('admin/events.show.connected_true')
            @else
                @lang('admin/events.show.connected_false')
            @endif
        </p>

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.events.edit', $event) }}">@lang('admin/events.show.edit_button')</a>
            <a class="button is-danger" href="{{ route('admin.events.delete', $event) }}">@lang('admin/events.show.delete_button')</a>
        </div>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.map')</h1>

        <div class="box" style="position: relative; padding-top: 50%; background-color: #191a1a; overflow: hidden;">
            <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
        </div>

        <script>
            window.data = {
                csrfToken: @json(csrf_token()),
                apiKey: @json(App\Models\ApiKey::where('name', 'Website')->first()->key),
                apiToken: @json(Auth::user()->apiToken()),
                mapboxAccessToken: @json(config('mapbox.access_token')),
                event: @json($event),
                links: {
                    apiEventsUpdate: @json(rawRoute('api.events.update')),
                    apiEventFinishesStore: @json(rawRoute('api.events.finishes.store')),
                    apiEventFinishesUpdate: @json(rawRoute('api.events.finishes.update')),
                    apiEventFinishesDelete: @json(rawRoute('api.events.finishes.delete'))
                },
                strings: {
                    add_point_button: @json(__('admin/events.show.map_add_point_button')),
                    add_finish_button: @json(__('admin/events.show.map_add_finish_button')),
                    connect_button: @json(__('admin/events.show.map_connect_button')),
                    disconnect_button: @json(__('admin/events.show.map_disconnect_button')),

                    path_length: @json(__('admin/events.show.map_path_length')),
                    path_length_message: @json(__('admin/events.show.map_path_length_message')),

                    latitude: @json(__('admin/events.show.map_latitude')),
                    longitude: @json(__('admin/events.show.map_longitude')),
                    delete_button: @json(__('admin/events.show.map_delete_button'))
                }
            };
        </script>
        <script src="/js/event_map.js"></script>
    </div>

    <!-- Event finishes -->
    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.finishes')</h1>

        @if ($eventFinishes->count() > 0)
            {{ $eventFinishes->links() }}

            @foreach ($eventFinishes as $eventFinish)
                <div class="box content">
                    <h1 class="title is-spaced is-4">
                        @lang('admin/events.show.finishes_name', ['finish.id' => $eventFinish->id])
                    </h1>
                    <p>@lang('admin/events.show.finishes_point_a') {{ $eventFinish->latitude_a }}, {{ $eventFinish->longitude_a }}</p>
                    <p>@lang('admin/events.show.finishes_point_b') {{ $eventFinish->latitude_b }}, {{ $eventFinish->longitude_b }}</p>
                    <div class="buttons">
                        <a class="button is-link" href="{{ route('admin.events.finishes.edit', ['event' => $event, 'eventFinish' => $eventFinish]) }}">
                            @lang('admin/events.show.finishes_edit_button')
                        </a>
                        <a class="button is-danger" href="{{ route('admin.events.finishes.delete', ['event' => $event, 'eventFinish' => $eventFinish]) }}">
                            @lang('admin/events.show.finishes_delete_button')
                        </a>
                    </div>
                </div>
            @endforeach

            {{ $eventFinishes->links() }}
        @else
            <p><i>@lang('admin/events.show.finishes_empty')</i></p>
        @endif

        <a class="button is-link"  href="{{ route('admin.events.finishes.create', ['event' => $event]) }}">
            @lang('admin/events.show.finishes_create_button')
        </a>
    </div>

    <!-- Event classes -->
    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.classes')</h1>

        @if ($eventClasses->count() > 0)
            {{ $eventClasses->links() }}

            @foreach ($eventClasses as $eventClass)
                <div class="box content">
                    @if ($eventClass->flag != NULL)
                        <img src="/images/flags/{{$eventClass->flag}}.svg" alt="{{$eventClass->flag}}" style="height: 50px">
                    @endif
                    <h1 class="title is-spaced is-4">{{ $eventClass->name }}</h1>

                    <div class="buttons">
                        <a class="button is-link" href="{{ route('admin.events.classes.edit', ['event' => $event, 'eventClass' => $eventClass]) }}">
                            @lang('admin/events.show.classes_edit_button')
                        </a>
                        <a class="button is-danger" href="{{ route('admin.events.classes.delete', ['event' => $event, 'eventClass' => $eventClass]) }}">
                            @lang('admin/events.show.classes_delete_button')
                        </a>
                    </div>

                    <!-- Event class fleets -->
                    @if ($eventClass->fleets->count() > 0)
                        <div class="box content">
                            <h2 class="title is-spaced is-4">@lang('admin/events.show.classes_fleets')</h2>

                            @foreach ($eventClass->fleets as $eventClassFleet)
                                <div class="box content">
                                    <h3 class="title is-spaced is-4">{{ $eventClassFleet->name }}</h3>

                                    <div class="buttons">
                                        <a class="button is-link" href="{{ route('admin.events.classes.fleets.edit', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet]) }}">
                                            @lang('admin/events.show.classes_fleets_edit_button')
                                        </a>
                                        <a class="button is-danger" href="{{ route('admin.events.classes.fleets.delete', ['event' => $event, 'eventClass' => $eventClass, 'eventClassFleet' => $eventClassFleet]) }}">
                                            @lang('admin/events.show.classes_fleets_delete_button')
                                        </a>
                                    </div>
                                </div>
                            @endforeach

                            <a class="button is-link"  href="{{ route('admin.events.classes.fleets.create', ['event' => $event, 'eventClass' => $eventClass]) }}">
                                @lang('admin/events.show.classes_fleets_create_button')
                            </a>
                        </div>
                    @else
                        <p><i>@lang('admin/events.show.classes_fleets_empty')</i></p>

                        <a class="button is-link" href="{{ route('admin.events.classes.fleets.create', ['event' => $event, 'eventClass' => $eventClass]) }}">
                            @lang('admin/events.show.classes_fleets_create_button')
                        </a>
                    @endif
                </div>
            @endforeach

            {{ $eventClasses->links() }}
        @else
            <p><i>@lang('admin/events.show.classes_empty')</i></p>
        @endif

        <a class="button is-link" href="{{ route('admin.events.classes.create', ['event' => $event]) }}">
            @lang('admin/events.show.classes_create_button')
        </a>
    </div>
@endsection
