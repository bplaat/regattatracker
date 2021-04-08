@extends('layout')

@section('title', __('admin/buoys.track.title', ['buoy.name' => $buoy->name]))

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
        <pre id="output" class="box">Debug Ouput</pre>
    @endif

    <script>
        const DEBUG = @json(config('app.debug'));
        const TRACKING_UPDATE_TIMEOUT = @json(config('tracker.update_timeout'));
        const CSRF_TOKEN = @json(csrf_token());
        const API_KEY = @json(App\Models\ApiKey::where('name', 'Website')->first()->key);
        const API_TOKEN = @json(Auth::user()->apiToken());
        mapboxgl.accessToken = @json(config('mapbox.access_token'));

        var logLines = [];
        function log(message) {
            if (DEBUG) {
                logLines.push(message);
                if (logLines.length > 20) {
                    logLines.shift();
                }
                logLines.reverse();
                output.textContent = logLines.join('\n');
                logLines.reverse();
            }
        }

        const buoy = @json($buoy);

        let oldPosition = {
            lat: buoy.positions[buoy.positions.length - 1].latitude,
            lng: buoy.positions[buoy.positions.length - 1].longitude
        };

        function isDarkModeEnabled() {
            return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        const map = new mapboxgl.Map({
            container: 'map-container',
            style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
            center: oldPosition,
            zoom: 12,
            attributionControl: false
        });

        const trackButton = document.getElementById('track-button');
        const timeLabel = document.getElementById('time-label');
        let isTracking = false;
        let isFirstTime;
        let geolocationWatch;
        let sendUpdateInterval;
        let nextUpdateTime;
        let textUpdateInterval;

        function sendCurrentPosition(currentPosition) {
            nextUpdateTime = Date.now() + TRACKING_UPDATE_TIMEOUT;
            log('Send position: ' + JSON.stringify(currentPosition));

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/buoys/' + buoy.id + '/positions', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', CSRF_TOKEN);
            xhr.setRequestHeader('Authorization', 'Bearer ' + API_TOKEN);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('api_key=' + API_KEY + '&' +
                'latitude=' + currentPosition.lat.toFixed(8) + '&' +
                'longitude=' + currentPosition.lng.toFixed(8));
        }

        function updateText() {
            timeLabel.textContent = "@lang('admin/buoys.track.send_text_prefix') " +
                ((nextUpdateTime - Date.now()) / 1000).toFixed(0) + " @lang('admin/buoys.track.send_text_suffix')";
        }

        map.on('load', () => {
            const marker = new mapboxgl.Marker().setLngLat(oldPosition).addTo(map);

            trackButton.addEventListener('click', () => {
                if ('geolocation' in navigator) {
                    if (!isTracking) {
                        log('Start tracking');
                        isTracking = true;
                        isFirstTime = true;
                        trackButton.textContent = "@lang('admin/buoys.track.stop_button')";
                        timeLabel.style.display = 'inline-block';
                        timeLabel.textContent = "@lang('admin/buoys.track.loading_text')";

                        geolocationWatch = navigator.geolocation.watchPosition(event => {
                            const currentPosition = { lat: event.coords.latitude, lng: event.coords.longitude };
                            log('Current position: ' + JSON.stringify(currentPosition));
                            marker.setLngLat(currentPosition);

                            const mapCenter = map.getCenter();
                            if (mapCenter.lat == oldPosition.lat && mapCenter.lng == oldPosition.lng) {
                                map.jumpTo({ center: currentPosition, zoom: 14 });
                            }

                            if (isFirstTime) {
                                isFirstTime = false;

                                sendCurrentPosition(currentPosition);
                                sendUpdateInterval = setInterval(function () {
                                    sendCurrentPosition(currentPosition);
                                }, TRACKING_UPDATE_TIMEOUT);

                                updateText();
                                textUpdateInterval = setInterval(updateText, 500);
                            }

                            oldPosition = currentPosition;
                        }, error => {
                            alert('Error: ' + error.message);
                        });
                    } else {
                        log('Stop tracking');
                        isTracking = false;
                        trackButton.textContent = "@lang('admin/buoys.track.start_button')";
                        timeLabel.style.display = 'none';

                        navigator.geolocation.clearWatch(geolocationWatch);
                        clearInterval(sendUpdateInterval);
                        clearInterval(textUpdateInterval);
                    }
                } else {
                    alert("@lang('admin/buoys.track.error')");
                }
            });
        });
    </script>
@endsection
