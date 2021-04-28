@extends('layout')

@section('title', __('home.title'))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
    @if (config('app.debug'))
        <style>.mapboxgl-ctrl-bottom-left .mapboxgl-ctrl{display:none!important}</style>
    @endif
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
            <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
        </div>

        <script>
            window.data = {
                websocketsReconnectTimeout: @json(config('websockets.reconnect_timeout')),
                websocketsUrl: 'ws://' + @json(config('websockets.host')) + ':' + @json(config('websockets.port')) + '/',
                mapboxAccessToken: @json(config('mapbox.access_token')),
                boats: @json($boats),
                buoys: @json($buoys),
                strings: {
                    latitude: @json(__('home.map_latitude')),
                    longitude: @json(__('home.map_longitude')),
                    time: @json(__('home.map_time'))
                }
            };
        </script>
        <script src="/js/items_live_map.js"></script>
    @endif
@endsection
