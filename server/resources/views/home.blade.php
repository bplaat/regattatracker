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

    @if (\App\Models\Boat::count() + \App\Models\Buoy::count() > 0 && \App\Models\BoatPosition::count() + \App\Models\BuoyPosition::count() > 0)
        <div class="box" style="position: relative; padding-top: 55%; background-color: #191a1a; overflow: hidden;">
            <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
        </div>

        <script>
            mapboxgl.accessToken = @json(config('mapbox.access_token'));

            var boats = @json(\App\Models\Boat::with(['positions'])->get());
            var buoys = @json(\App\Models\Buoy::with(['positions'])->get());

            function isDarkModeEnabled() {
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            var map = new mapboxgl.Map({
                container: 'map-container',
                style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
                center: (boats.length > 0 ? [
                    boats[0].positions[boats[0].positions.length - 1].longitude,
                    boats[0].positions[boats[0].positions.length - 1].latitude
                ] : [
                    buoys[0].positions[buoys[0].positions.length - 1].longitude,
                    buoys[0].positions[buoys[0].positions.length - 1].latitude
                ]),
                zoom: 9,
                attributionControl: false
            });

            map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');

            map.on('load', function () {
                map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png', function (error, image) {
                    if (error) throw error;
                    map.addImage('custom-marker', image);

                    // Boats
                    var boatFeatures = [];
                    for (var i = 0; i < boats.length; i++) {
                        var boat = boats[i];

                        if (boat.positions.length > 0) {
                            boatFeatures.push({
                                type: 'Feature',
                                properties: {
                                    boat: boat
                                },
                                geometry: {
                                    type: 'Point',
                                    coordinates: [
                                        boat.positions[boat.positions.length - 1].longitude,
                                        boat.positions[boat.positions.length - 1].latitude
                                    ]
                                }
                            });
                        }
                    }

                    map.addSource('boats', {
                        type: 'geojson',
                        data: {
                            type: 'FeatureCollection',
                            features: boatFeatures
                        }
                    });

                    map.addLayer({
                        id: 'boats',
                        type: 'symbol',
                        source: 'boats',
                        layout: {
                            'icon-image': 'custom-marker',
                            'text-field': 'Boat'
                        }
                    });

                    map.on('click', 'boats', function (event) {
                        var boat = JSON.parse(event.features[0].properties.boat);
                        var boatPosition = event.features[0].geometry.coordinates.slice();

                        new mapboxgl.Popup()
                            .setLngLat(boatPosition)
                            .setHTML('<h2 style="font-weight: bold; font-size: 18px; margin-bottom: 12px;">' + boat.name + '</h2>' +
                                (boat.description != null ? '<p>' + boat.description + '</p>' : '')
                            )
                            .addTo(map);
                    });

                    map.on('mouseenter', 'boats', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'boats', function () {
                        map.getCanvas().style.cursor = '';
                    });

                    // Buoys
                    var buoyFeatures = [];
                    for (var i = 0; i < buoys.length; i++) {
                        var buoy = buoys[i];

                        if (buoy.positions.length > 0) {
                            buoyFeatures.push({
                                type: 'Feature',
                                properties: {
                                    buoy: buoy
                                },
                                geometry: {
                                    type: 'Point',
                                    coordinates: [
                                        buoy.positions[buoy.positions.length - 1].longitude,
                                        buoy.positions[buoy.positions.length - 1].latitude
                                    ]
                                }
                            });
                        }
                    }

                    map.addSource('buoys', {
                        type: 'geojson',
                        data: {
                            type: 'FeatureCollection',
                            features: buoyFeatures
                        }
                    });

                    map.addLayer({
                        id: 'buoys',
                        type: 'symbol',
                        source: 'buoys',
                        layout: {
                            'icon-image': 'custom-marker',
                            'text-field': 'Buoy'
                        }
                    });

                    map.on('click', 'buoys', function (event) {
                        var buoy = JSON.parse(event.features[0].properties.buoy);
                        var buoyPosition = event.features[0].geometry.coordinates.slice();

                        new mapboxgl.Popup()
                            .setLngLat(buoyPosition)
                            .setHTML('<h2 style="font-weight: bold; font-size: 18px; margin-bottom: 12px;">' + buoy.name + '</h2>' +
                                (buoy.description != null ? '<p>' + buoy.description + '</p>' : '')
                            )
                            .addTo(map);
                    });

                    map.on('mouseenter', 'buoys', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'buoys', function () {
                        map.getCanvas().style.cursor = '';
                    });
                });
            });

            // Open websocket connection with the server
            var ws = new WebSocket('ws://' + @json(config('websockets.host')) + ':' + @json(config('websockets.port')) + '/');

            ws.onopen = function () {
                ws.send('hello!');
            };

            ws.onmessage = function (event) {
                console.log(event);
            };
        </script>
    @endif
@endsection
