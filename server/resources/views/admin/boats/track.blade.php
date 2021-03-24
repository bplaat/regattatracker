@extends('layout')

@section('title', __('admin/boats.track.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
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
        <button id="track-button" class="button is-link">Start tracking</button>
    </div>

<script>
    mapboxgl.accessToken = @json(config('mapbox.access_token'));
    var map = new mapboxgl.Map({
        container: 'map-container',
        style: 'mapbox://styles/mapbox/dark-v10',
        center: [5.4059754, 52.6758974],
        zoom: 9
    });

    new mapboxgl.Marker()
        .setLngLat([5.4059754, 52.6758974])
        .addTo(map);

    // if ('geolocation' in navigator) {
    //     navigator.geolocation.watchPosition(function (position) {
    //         console.log(position.cords);
    //     }, function (error) {
    //         alert(error.message);
    //     });
    // } else {
    //     alert('Your browser doesn\t support geolocation tracking!');
    // }
</script>
@endsection
