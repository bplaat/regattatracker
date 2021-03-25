@extends('layout')

@section('title', __('boats.track.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"/>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('boats.track', $boat) }}">@lang('boats.track.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="box" style="position: relative; padding-top: 55%; background-color: #191a1a; overflow: hidden;">
        <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
    </div>

    <div class="buttons is-centered">
        <button id="track-button" class="button is-link">Start tracking</button>
    </div>

    <script>
        mapboxgl.accessToken = @json(config('mapbox.access_token'));

        var boatPositions = @json($boatPositions);

        var latestPosition = [
            parseFloat(boatPositions[boatPositions.length - 1].longitude),
            parseFloat(boatPositions[boatPositions.length - 1].latitude)
        ];

        var map = new mapboxgl.Map({
            container: 'map-container',
            style: 'mapbox://styles/mapbox/dark-v10',
            center: latestPosition,
            zoom: 9
        });

        map.on('load', function () {
            new mapboxgl.Marker().setLngLat(latestPosition).addTo(map);

            // if ('geolocation' in navigator) {
            //     navigator.geolocation.watchPosition(function (position) {
            //         console.log(position.cords);
            //     }, function (error) {
            //         alert(error.message);
            //     });
            // } else {
            //     alert('Your browser doesn\t support geolocation tracking!');
            // }
        });
    </script>
@endsection
