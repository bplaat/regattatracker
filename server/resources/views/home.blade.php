@extends('layout')

@section('title', __('home.title'))

@section('head')
    <link rel="stylesheet" href="/css/mapbox-gl.min.css" />
    <script src="/js/mapbox-gl.min.js"></script>
@endsection

@section('content')
    <div class="content">
        @auth
            <h1 class="title">@lang('home.header_auth', ['user.firstname' => Auth::user()->firstname])</h1>
        @else
            <h1 class="title">@lang('home.header_guest')</h1>
            <p>@lang('home.description')</p>
        @endauth
    </div>

    @if ($itemsData)
        <div class="box" style="position: relative; padding-top: 55%; background-color: #191a1a; overflow: hidden;">
            <div id="map-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
        </div>

        @if (config('app.debug'))
            <pre id="output" class="box">Debug Output</pre>
        @endif

        <script>
            window.data = {
                debug: @json(config('app.debug')),
                websocketsReconnectTimeout: @json(config('websockets.reconnect_timeout')),
                websocketsUrl: 'ws://' + @json(config('websockets.host')) + ':' + @json(config('websockets.port')) + '/',
                mapboxAccessToken: @json(config('mapbox.access_token')),
                openweatherApiKey: @json(config('openweather.api_key')),
                boats: @json($boats),
                buoys: @json($buoys),
                strings: {
                    connection_error: @json(__('home.map_connection_error')),
                    connection_message: @json(__('home.map_connection_message')),
                    legend: @json(__('home.map_legend')),
                    legend_boat: @json(__('home.map_legend_boat')),
                    legend_buoy: @json(__('home.map_legend_buoy')),
                    wind_message: @json(__('home.map_wind_message')),
                    wind_loading: @json(__('home.map_wind_loading')),
                    boat_image_alt: @json(__('home.map_boat_image_alt')),
                    latitude: @json(__('home.map_latitude')),
                    longitude: @json(__('home.map_longitude')),
                    time: @json(__('home.map_time'))
                }
            };
        </script>
        <script src="/js/items_live_map.js"></script>
    @endif
@endsection
