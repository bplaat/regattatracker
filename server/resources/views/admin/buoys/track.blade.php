@extends('layout')

@section('title', __('admin/buoys.track.title', ['buoy.name' => $buoy->name]))

@section('head')
    <link rel="stylesheet" href="/css/mapbox-gl.css" />
    <script src="/js/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.track', $buoy) }}">@lang('admin/buoys.track.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="box" style="position: relative; padding-top: 55%; background-color: #191a1a; overflow: hidden;">
        <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
    </div>

    <div class="buttons is-centered">
        <button id="track-button" class="button is-link">@lang('admin/buoys.track.start_button')</button>
        <span id="time-label" class="tag" style="display: none; margin-left: 24px;"></span>
    </div>

    @if (config('app.debug'))
        <pre id="output" class="box">Debug Output</pre>
    @endif

    <script>
        window.data = {
            type: 'buoy',
            debug: @json(config('app.debug')),
            csrfToken: @json(csrf_token()),
            apiKey: @json(App\Models\ApiKey::where('name', 'Website')->first()->key),
            apiToken: @json(Auth::user()->apiToken()),
            mapboxAccessToken: @json(config('mapbox.access_token')),
            trackingUpdateTimeout: @json(config('tracker.update_timeout')),
            item: @json($buoy),
            positions: @json($buoyPositions),
            links: {
                apiPositionsStore: @json(route('api.buoys.positions.store', $buoy)),
                positionsPrefix: @json(route('admin.buoys.positions.store', $buoy))
            },
            strings: {
                name: @json(__('admin/buoys.track.map_name')),
                current: @json(__('admin/buoys.track.map_current')),
                latitude: @json(__('admin/buoys.track.map_latitude')),
                longitude: @json(__('admin/buoys.track.map_longitude')),
                time: @json(__('admin/buoys.track.map_time')),
                edit_button: @json(__('admin/buoys.track.map_edit_button')),
                delete_button: @json(__('admin/buoys.track.map_delete_button')),

                start_button: @json(__('admin/buoys.track.start_button')),
                stop_button: @json(__('admin/buoys.track.stop_button')),
                loading: @json(__('admin/buoys.track.loading')),
                sending: @json(__('admin/buoys.track.sending')),
                error_message: @json(__('admin/buoys.track.error_message'))
            }
        };
    </script>
    <script src="/js/item_tracker_map.js"></script>
@endsection
