const type = window.data.type;
const debug = window.data.debug;
const csrfToken = window.data.csrfToken;
const apiKey = window.data.apiKey;
const apiToken = window.data.apiToken;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const trackingUpdateTimeout = window.data.trackingUpdateTimeout;
const item = window.data.item;
const positions = window.data.positions;
const links = window.data.links;
const strings = window.data.strings;

const logLines = [];
function log(message) {
    if (debug) {
        logLines.unshift(message);
        if (logLines.length > 20) {
            logLines.pop();
        }
        output.textContent = logLines.join('\n');
    }
}

function isDarkModeEnabled() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

let oldPosition = { lat: positions[0].latitude,lng: positions[0].longitude };

const map = new mapboxgl.Map({
    container: 'map-container',
    style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
    center: oldPosition,
    zoom: 12,
    attributionControl: false
});

map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');

const trackButton = document.getElementById('track-button');
const timeLabel = document.getElementById('time-label');
let isTracking = false;
let isFirstTime;
let geolocationWatch;
let sendUpdateInterval;
let nextUpdateTime;
let textUpdateInterval;

function mapMouseEnter(event) {
    map.getCanvas().style.cursor = 'pointer';
    map.getCanvas().title = event.lngLat.lat + ', ' + event.lngLat.lng;
}

function mapMouseLeave() {
    map.getCanvas().style.cursor = '';
    map.getCanvas().title = '';
}

function updateMapItems() {
    // Current position layer
    const currentPositionPoint = {
        type: 'Feature',
        properties: {
            position: positions[0]
        },
        geometry: {
            type: 'Point',
            coordinates: [positions[0].longitude, positions[0].latitude]
        }
    };

    if (map.getSource('current_position_point') != undefined) {
        map.getSource('current_position_point').setData(currentPositionPoint);
    } else {
        map.addSource('current_position_point', { type: 'geojson', data: currentPositionPoint });

        map.addLayer({
            id: 'current_position_point',
            source: 'current_position_point',
            type: 'circle',
            paint: {
                'circle-color': type == 'boat' ? 'rgb(246, 140, 30)' : 'rgb(50, 148, 209)',
                'circle-radius': 10,
                'circle-stroke-width': 2,
                'circle-stroke-color': type == 'boat' ? 'rgb(245, 198, 147)' : 'rgb(49, 206, 255)'
            }
        });

        map.on('click', 'current_position_point', event => {
            const position = JSON.parse(event.features[0].properties.position);

            new mapboxgl.Popup()
                .setLngLat([position.longitude, position.latitude])
                .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + strings.name.replace(':item_position.id', position.id) + '</h3>' +
                    '<div><b>' + strings.current + '</b></div>' +
                    '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                    '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                    '<div>' + strings.time + ': ' + new Date(position.created_at).toLocaleString('en-US') + '</div>' +
                    '<div><a href="' + links.positionsPrefix + '/' + position.id + '/edit">' + strings.edit_button + '</a> ' +
                        '<a href="' + links.positionsPrefix + '/' + position.id + '/delete">' + strings.delete_button + '</a></div>'
                )
                .addTo(map);
        });

        map.on('mouseenter', 'current_position_point', mapMouseEnter);
        map.on('mouseleave', 'current_position_point', mapMouseLeave);
    }

    if (positions.length > 1) {
        // Old positions points layer
        const oldPositionPoints = {
            type: 'FeatureCollection',
            features: positions.slice(1).map(position => ({
                type: 'Feature',
                properties: {
                    position: position
                },
                geometry: {
                    type: 'Point',
                    coordinates: [position.longitude, position.latitude]
                }
            }))
        };

        if (map.getSource('old_position_points') != undefined) {
            map.getSource('old_position_points').setData(oldPositionPoints);
        } else {
            map.addSource('old_position_points', { type: 'geojson', data: oldPositionPoints });

            map.addLayer({
                id: 'old_position_points',
                source: 'old_position_points',
                type: 'circle',
                paint: {
                    'circle-color': '#a2a2a2',
                    'circle-radius': 6
                }
            }, 'current_position_point');

            map.on('click', 'old_position_points', event => {
                const position = JSON.parse(event.features[0].properties.position);

                new mapboxgl.Popup()
                    .setLngLat([position.longitude, position.latitude])
                    .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + strings.name.replace(':item_position.id',  position.id) + '</h3>' +
                        '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                        '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                        '<div>' + strings.time + ': ' + new Date(position.created_at).toLocaleString('en-US') + '</div>' +
                        '<div><a href="' + links.positionsPrefix + '/' + position.id + '/edit">' + strings.edit_button + '</a> ' +
                            '<a href="' + links.positionsPrefix + '/' + position.id + '/delete">' + strings.delete_button + '</a></div>'
                    )
                    .addTo(map);
            });

            map.on('mouseenter', 'old_position_points', mapMouseEnter);
            map.on('mouseleave', 'old_position_points', mapMouseLeave);
        }

        // Positions line layer
        const positionsLine = {
            type: 'Feature',
            geometry: {
                type: 'LineString',
                coordinates: positions.map(position =>
                    [position.longitude, position.latitude]
                )
            }
        };

        if (map.getSource('positions_line') != undefined) {
            map.getSource('positions_line').setData(positionsLine);
        } else {
            map.addSource('positions_line', { type: 'geojson', data: positionsLine });

            map.addLayer({
                id: 'positions_line',
                source: 'positions_line',
                type: 'line',
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#a2a2a2',
                    'line-width': 4
                }
            }, 'old_position_points');
        }
    }
}

function sendCurrentPosition(currentPosition) {
    nextUpdateTime = Date.now() + trackingUpdateTimeout;

    log('Send position: ' + JSON.stringify(currentPosition));

    const xhr = new XMLHttpRequest();
    xhr.onload = function () {
        // Add new position to positions
        const position = JSON.parse(xhr.responseText);
        positions.unshift(position);
        log('Position received: ' + JSON.stringify(position));

        // And update map items
        updateMapItems();
    };
    xhr.open('POST', links.apiPositionsStore, true);
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhr.setRequestHeader('Authorization', 'Bearer ' + apiToken);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.send('api_key=' + apiKey + '&' +
        'latitude=' + currentPosition.lat.toFixed(8) + '&' +
        'longitude=' + currentPosition.lng.toFixed(8));
}

function updateText() {
    timeLabel.textContent = strings.sending.replace(':seconds', ((nextUpdateTime - Date.now()) / 1000).toFixed(0));
}

map.on('load', () => {
    // Add map items
    updateMapItems();

    // Tracker button
    trackButton.addEventListener('click', () => {
        if ('geolocation' in navigator) {
            if (!isTracking) {
                log('Start tracking');
                isTracking = true;
                isFirstTime = true;
                trackButton.textContent = strings.stop_button;
                timeLabel.style.display = 'inline-block';
                timeLabel.textContent = strings.loading;

                geolocationWatch = navigator.geolocation.watchPosition(event => {
                    const currentPosition = { lat: event.coords.latitude, lng: event.coords.longitude };
                    log('Current position: ' + JSON.stringify(currentPosition));

                    const mapCenter = map.getCenter();
                    if (mapCenter.lat == oldPosition.lat && mapCenter.lng == oldPosition.lng) {
                        map.jumpTo({ center: currentPosition, zoom: 14 });
                    }

                    if (isFirstTime) {
                        isFirstTime = false;

                        sendCurrentPosition(currentPosition);
                        sendUpdateInterval = setInterval(() => {
                            sendCurrentPosition(currentPosition);
                        }, trackingUpdateTimeout);

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
                trackButton.textContent = strings.start_button;
                timeLabel.style.display = 'none';

                navigator.geolocation.clearWatch(geolocationWatch);
                clearInterval(sendUpdateInterval);
                clearInterval(textUpdateInterval);
            }
        } else {
            alert(strings.error_message);
        }
    });
});
