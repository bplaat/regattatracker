@extends('layout')

@section('title', __('admin/boats.track.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
    @if (config('app.debug'))
        <style>.mapboxgl-ctrl-bottom-left .mapboxgl-ctrl{display:none!important}</style>
    @endif
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.track', $boat) }}">@lang('admin/boats.track.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="box" style="position: relative; padding-top: 55%; background-color: #191a1a; overflow: hidden;">
        <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
    </div>

    <div class="buttons is-centered">
        <button id="track-button" class="button is-link">@lang('admin/boats.track.start_button')</button>
        <span id="time-label" class="tag" style="display: none; margin-left: 24px;"></span>
    </div>

    @if (config('app.debug'))
        <pre id="output" class="box">Debug Output</pre>
    @endif

    <script>
        window.data = {
            type: 'boat',
            debug: @json(config('app.debug')),
            csrfToken: @json(csrf_token()),
            apiKey: @json(App\Models\ApiKey::where('name', 'Website')->first()->key),
            apiToken: @json(Auth::user()->apiToken()),
            mapboxAccessToken: @json(config('mapbox.access_token')),
            trackingUpdateTimeout: @json(config('tracker.update_timeout')),
            item: @json($boat),
            positions: @json($boatPositions),
            links: {
                apiPositionsStore: @json(route('api.boats.positions.store', $boat)),
                positionsPrefix: @json(route('admin.boats.positions.store', $boat))
            },
            strings: {
                title: @json(__('admin/boats.track.map_title')),
                current: @json(__('admin/boats.track.map_current')),
                latitude: @json(__('admin/boats.track.map_latitude')),
                longitude: @json(__('admin/boats.track.map_longitude')),
                time: @json(__('admin/boats.track.map_time')),
                edit: @json(__('admin/boats.track.map_edit')),
                delete: @json(__('admin/boats.track.map_delete')),

                start_button: @json(__('admin/boats.track.start_button')),
                stop_button: @json(__('admin/boats.track.stop_button')),
                loading_text: @json(__('admin/boats.track.loading_text')),
                send_text_prefix: @json(__('admin/boats.track.send_text_prefix')),
                send_text_suffix: @json(__('admin/boats.track.send_text_suffix')),
                error: @json(__('admin/boats.track.error'))
            }
        };
    </script>
    <script src="/js/item_tracker_map.js"></script>
@endsection
