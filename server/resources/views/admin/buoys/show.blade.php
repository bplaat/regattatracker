@extends('layout')

@section('title', __('admin/buoys.show.title', ['buoy.name' => $buoy->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"/>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $buoy->name }}</h1>
        @if ($buoy->description != null)
            <p style="white-space: pre-wrap;">{{ $buoy->description }}</p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.buoys.edit', $buoy) }}">@lang('admin/buoys.show.edit')</a>
            <a class="button is-danger"
               href="{{ route('admin.buoys.delete', $buoy) }}">@lang('admin/buoys.show.delete')</a>
        </div>
    </div>

    <!-- Buoy location -->
    <div class="box content">
        <h2 class="tile is-4">@lang('admin/buoys.show.locations')</h2>

        <form method="POST" action="{{route('admin.buoys.location.add_location', $buoy)}}">
            @csrf

            <h2 class="subtitle is-5">@lang('admin/buoys.show.location_creator')</h2>
            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="latitude">@lang('admin/buoys.show.latitude')</label>
                        <div class="control">
                            <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude"
                                   name="latitude" value="{{old('latitude')}}" required>
                        </div>
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="longitude">@lang('admin/buoys.show.longitude')</label>
                        <div class="control">
                            <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude"
                                   name="longitude" value="{{old('longitude')}}" required>
                        </div>
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="message is-danger">
                    <div class="message-body">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit">@lang('admin/buoys.show.create_point')</button>
                </div>
            </div>
        </form>

        <h2 class="subtitle is-5">@lang('admin/buoys.show.location_map')</h2>
        <div style="position: relative; width: 100%; padding-top: 55%; margin-bottom: 24px; background-color: #191a1a;">
            <div id="map-container" style="position: absolute; top: 0; width: 100%; height: 100%;"></div>
        </div>
    </div>
    <script>
        mapboxgl.accessToken = @json(config('mapbox.access_token'));
        var map = new mapboxgl.Map({
            container: 'map-container',
            style: 'mapbox://styles/mapbox/dark-v10',
            center: [5.4059754, 52.6758974],
            zoom: 9
        });

        @if ($buoyPositions->count() > 0)
        new mapboxgl.Marker()
            .setLngLat([{{$buoyPositions[0]->latitude}}, {{$buoyPositions[0]->longitude}}])
            .addTo(map);
        @endif

        @if ($buoyPositions->count() > 1)
        var line = [];
        @foreach($buoyPositions as $buoyPosition)
        line.push([{{$buoyPosition->latitude}}, {{$buoyPosition->longitude}}]);
        @endforeach
        map.on('load', function () {
            map.addSource('route', {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'properties': {},
                    'geometry': {
                        'type': 'LineString',
                        'coordinates': line
                    }
                }
            });
            map.addLayer({
                'id': 'route',
                'type': 'line',
                'source': 'route',
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': '#a2a2a2',
                    'line-width': 8
                }
            });
        });
        new mapboxgl.Marker()
            .setLngLat([{{$buoyPositions->last()->latitude}}, {{$buoyPositions->last()->longitude}}])
            .addTo(map);
        @endif

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
