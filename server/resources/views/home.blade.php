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
            const WEBSOCKETS_RECONNECT_TIMEOUT = @json(config('websockets.reconnect_timeout'));
            mapboxgl.accessToken = @json(config('mapbox.access_token'));

            const boats = @json(\App\Models\Boat::with(['positions'])->get());
            const buoys = @json(\App\Models\Buoy::with(['positions'])->get());

            function isDarkModeEnabled() {
                return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            const map = new mapboxgl.Map({
                container: 'map-container',
                style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
                attributionControl: false
            });
            map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');

            const boatPositions = boats.map(boat => boat.positions[boat.positions.length - 1]);
            const buoyPositions = buoys.map(buoy => buoy.positions[buoy.positions.length - 1]);
            const allPositions = boatPositions.concat(buoyPositions).map(position => [position.longitude, position.latitude ]);

            var bounds = allPositions.reduce(function (bounds, position) {
                return bounds.extend(position);
            }, new mapboxgl.LngLatBounds(allPositions[0], allPositions[0]));
            map.fitBounds(bounds, { padding: 50, maxZoom: 10 });

            map.on('load', () => {
                map.loadImage('https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png', (error, image) => {
                    if (error) throw error;
                    map.addImage('custom-marker', image);

                    // Boats
                    const boatFeatures = [];
                    for (const boat of boats) {
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

                    map.on('click', 'boats', event => {
                        const boat = JSON.parse(event.features[0].properties.boat);
                        const boatPosition = event.features[0].geometry.coordinates.slice();

                        new mapboxgl.Popup()
                            .setLngLat(boatPosition)
                            .setHTML('<h2 style="font-weight: bold; font-size: 18px; margin-bottom: 12px;">' + boat.name + '</h2>' +
                                (boat.description != null ? '<p>' + boat.description + '</p>' : '')
                            )
                            .addTo(map);
                    });

                    map.on('mouseenter', 'boats', () => {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'boats', () => {
                        map.getCanvas().style.cursor = '';
                    });

                    // Buoys
                    const buoyFeatures = [];
                    for (const buoy of buoys) {
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

                    map.on('click', 'buoys', event => {
                        const buoy = JSON.parse(event.features[0].properties.buoy);
                        const buoyPosition = event.features[0].geometry.coordinates.slice();

                        new mapboxgl.Popup()
                            .setLngLat(buoyPosition)
                            .setHTML('<h2 style="font-weight: bold; font-size: 18px; margin-bottom: 12px;">' + buoy.name + '</h2>' +
                                (buoy.description != null ? '<p>' + buoy.description + '</p>' : '')
                            )
                            .addTo(map);
                    });

                    map.on('mouseenter', 'buoys', () => {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    map.on('mouseleave', 'buoys', () => {
                        map.getCanvas().style.cursor = '';
                    });
                });
            });

            // Connect to websocket server
            let isFirstWebSocketError = true;
            function connectToWebSocketServer() {
                const ws = new WebSocket('ws://' + @json(config('websockets.host')) + ':' + @json(config('websockets.port')) + '/');

                ws.onopen = () => {
                    console.log('WebSocket connected!');
                };

                ws.onmessage = event => {
                    const data = JSON.parse(event.data);
                    console.log(data);

                    // On new boat position
                    if (data.type == 'new_boat_position') {
                        const boatFeatures = map.getSource('boats')._data; // Ugly???

                        const boatFeature = boatFeatures.features.find(boatFeature =>
                            boatFeature.properties.boat.id == data.boatPosition.boat_id);

                        if (boatFeature != null) {
                            boatFeature.geometry.coordinates = [
                                data.boatPosition.longitude,
                                data.boatPosition.latitude
                            ];

                            map.getSource('boats').setData(boatFeatures);
                        }
                    }

                    // On new buoy position
                    if (data.type == 'new_buoy_position') {
                        const buoyFeatures = map.getSource('buoys')._data; // Ugly???

                        const buoyFeature = buoyFeatures.features.find(buoyFeature =>
                            buoyFeature.properties.buoy.id == data.buoyPosition.buoy_id);

                        if (buoyFeature != null) {
                            buoyFeature.geometry.coordinates = [
                                data.buoyPosition.longitude,
                                data.buoyPosition.latitude
                            ];

                            map.getSource('buoys').setData(buoyFeatures);
                        }
                    }
                };

                // When the connection to the websocket server is lost try to reconnect after
                ws.onclose = () => {
                    console.log('WebSocket disconnected!');
                    setTimeout(connectToWebSocketServer, WEBSOCKETS_RECONNECT_TIMEOUT);
                }

                ws.onerror = event => {
                    if (isFirstWebSocketError) {
                        isFirstWebSocketError = false;
                        alert('Can\'t connect to the websocket server!');
                    }
                };
            }
            connectToWebSocketServer();
        </script>
    @endif
@endsection
