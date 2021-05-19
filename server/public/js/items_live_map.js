const websocketsReconnectTimeout = window.data.websocketsReconnectTimeout;
const websocketsUrl = window.data.websocketsUrl;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const boats = window.data.boats;
const buoys = window.data.buoys;
const strings = window.data.strings;

let boatsChanged = true;
let buoysChanged = true;

function isDarkModeEnabled() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

const map = new mapboxgl.Map({
    container: 'map-container',
    style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
    center: [5.45, 52.3],
    zoom: 6,
    attributionControl: false
});

const allPositions = boats.map(boat => boat.positions[0])
    .concat(buoys.map(buoy => buoy.positions[0]))
    .map(position => [position.longitude, position.latitude ]);

const bounds = allPositions.reduce(function (bounds, position) {
    return bounds.extend(position);
}, new mapboxgl.LngLatBounds(allPositions[0], allPositions[0]));
map.fitBounds(bounds, { animate: false, padding: 50 });

map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.GeolocateControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');

function mapMouseEnter(event) {
    map.getCanvas().style.cursor = 'pointer';
    map.getCanvas().title = event.lngLat.lat + ', ' + event.lngLat.lng;
}

function mapMouseLeave() {
    map.getCanvas().style.cursor = '';
    map.getCanvas().title = '';
}

function updateMapItems() {
    // Boat points
    if (boatsChanged) {
        boatsChanged = false;

        const boatPoints = {
            type: 'FeatureCollection',
            features: boats.filter(boat => boat.positions.length > 0).map(boat => ({
                type: 'Feature',
                properties: {
                    boat: boat
                },
                geometry: {
                    type: 'Point',
                    coordinates: [boat.positions[0].longitude, boat.positions[0].latitude]
                }
            }))
        };

        if (map.getSource('boat_points') != undefined) {
            map.getSource('boat_points').setData(boatPoints);
        } else {
            map.addSource('boat_points', { type: 'geojson', data: boatPoints });

            map.addLayer({
                id: 'boat_points',
                source: 'boat_points',
                type: 'circle',
                paint: {
                    'circle-color': 'rgb(246, 140, 30)',
                    'circle-radius': 10,
                    'circle-stroke-width': 2,
                    'circle-stroke-color': 'rgb(245, 198, 147)'
                }
            });

            map.on('click', 'boat_points', event => {
                const boat = JSON.parse(event.features[0].properties.boat);
                const position = boat.positions[0];

                new mapboxgl.Popup()
                    .setLngLat([position.longitude, position.latitude])
                    .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + boat.name + '</h3>' +
                        '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                        '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                        '<div>' + strings.time + ': ' + new Date(position.created_at).toLocaleString('en-US') + '</div>'
                    )
                    .addTo(map);
            });

            map.on('mouseenter', 'boat_points', mapMouseEnter);
            map.on('mouseleave', 'boat_points', mapMouseLeave);
        }
    }

    // Buoy points
    if (buoysChanged) {
        buoysChanged = false;

        const buoyPoints = {
            type: 'FeatureCollection',
            features: buoys.filter(buoy => buoy.positions.length > 0).map(buoy => ({
                type: 'Feature',
                properties: {
                    buoy: buoy
                },
                geometry: {
                    type: 'Point',
                    coordinates: [buoy.positions[0].longitude, buoy.positions[0].latitude]
                }
            }))
        };

        if (map.getSource('buoy_points') != undefined) {
            map.getSource('buoy_points').setData(buoyPoints);
        } else {
            map.addSource('buoy_points', { type: 'geojson', data: buoyPoints });

            map.addLayer({
                id: 'buoy_points',
                source: 'buoy_points',
                type: 'circle',
                paint: {
                    'circle-color': 'rgb(50, 148, 209)',
                    'circle-radius': 10,
                    'circle-stroke-width': 2,
                    'circle-stroke-color': 'rgb(49, 206, 255)'
                }
            }, 'boat_points');

            map.on('click', 'buoy_points', event => {
                const buoy = JSON.parse(event.features[0].properties.buoy);
                const position = buoy.positions[0];

                new mapboxgl.Popup()
                    .setLngLat([position.longitude, position.latitude])
                    .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + buoy.name + '</h3>' +
                        '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                        '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                        '<div>' + strings.time + ': ' + new Date(position.created_at).toLocaleString('en-US') + '</div>'
                    )
                    .addTo(map);
            });

            map.on('mouseenter', 'buoy_points', mapMouseEnter);
            map.on('mouseleave', 'buoy_points', mapMouseLeave);
        }
    }
}

map.on('load', () => {
    // Add map items
    updateMapItems();
});

// Connect to websocket server
let isFirstWebSocketError = true;
function connectToWebSocketServer() {
    const ws = new WebSocket(websocketsUrl);

    ws.onopen = () => {
        console.log('WebSocket connected!');
    };

    ws.onmessage = event => {
        const data = JSON.parse(event.data);
        console.log('Websocket message: ', data);

        // On new boat position
        if (data.type == 'new_boat_position') {
            const boat = boats.find(boat => boat.id == data.boatPosition.boat_id);
            if (boat != undefined) {
                boat.positions.unshift(data.boatPosition);
                boatsChanged = true;
                updateMapItems();
            }
        }

        // On new buoy position
        if (data.type == 'new_buoy_position') {
            const buoy = buoys.find(buoy => buoy.id == data.buoyPosition.buoy_id);
            if (buoy != undefined) {
                buoy.positions.unshift(data.buoyPosition);
                buoysChanged = true;
                updateMapItems();
            }
        }
    };

    // When the connection to the websocket server is lost try to reconnect after
    ws.onclose = () => {
        console.log('WebSocket disconnected!');
        setTimeout(connectToWebSocketServer, websocketsReconnectTimeout);
    };

    ws.onerror = event => {
        if (isFirstWebSocketError) {
            isFirstWebSocketError = false;
            alert('Can\'t connect to the websocket server!');
        }
    };
}
connectToWebSocketServer();
