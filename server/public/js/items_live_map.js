const debug = window.data.debug;
const websocketsReconnectTimeout = window.data.websocketsReconnectTimeout;
const websocketsUrl = window.data.websocketsUrl;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const openweatherApiKey = window.data.openweatherApiKey;
const boats = window.data.boats;
const buoys = window.data.buoys;
const strings = window.data.strings;

const outputElement = document.getElementById('output');
const logLines = [];
function log(message) {
    if (debug) {
        logLines.unshift(message);
        if (logLines.length > 20) {
            logLines.pop();
        }
        outputElement.textContent = logLines.join('\n');
    }
}

let boatsChanged = true;
let buoysChanged = true;

let selectedBoat = undefined;
let selectedBoatPopup = undefined;

let selectedBuoy = undefined;
let selectedBuoyPopup = undefined;

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

class MessageControl {
    constructor(text) {
        this.text = text;
    }

    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
        this._container.style = 'padding: 4px 8px;';
        this._container.textContent = this.text;
        return this._container;
    }

    onRemove() {
        this._map = undefined;
        this._container.parentNode.removeChild(this._container);
    }
}

class WindInfoControl {
    onAdd(map) {
        this._map = map;

        this.unit = localStorage.wind_unit || 'm/s';

        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
        this._container.style = 'padding: 4px 8px 8px; cursor: pointer; user-select: none;';
        this._container.title = strings.wind_message;
        this._container.innerHTML = `
            <svg viewBox="0 0 24 24" style="display: block; margin: 0 auto 4px; width: 48px; height: 48px; transition: transform 0.2s ease-in-out">
                <path fill="currentColor" d="M13,18H11V10L7.5,13.5L6.08,12.08L12,6.16L17.92,12.08L16.5,13.5L13,10V18M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z" />
            </svg>
            <p style="font-weight: bold;"></p>
        `;
        this.onUpdate();

        this._container.addEventListener('click', () => {
            if (this.unit == 'm/s') {
                this.unit = 'km/h';
            } else if (this.unit == 'km/h') {
                this.unit = 'nm/h';
            } else {
                this.unit = 'm/s';
            }
            localStorage.wind_unit = this.unit;
            this.onUpdate();
        });

        this.getWeatherInfo();
        setInterval(this.getWeatherInfo.bind(this), 10 * 60 * 1000);

        return this._container;
    }

    onUpdate() {
        if (this.windDeg != undefined && this.windSpeed != undefined) {
            this._container.children[0].style.transform = 'rotate(' + this.windDeg + 'deg)';
            if (this.unit == 'm/s') {
                this._container.children[1].textContent = this.windSpeed.toFixed(2) + ' m/s';
            }
            if (this.unit == 'km/h') {
                this._container.children[1].textContent = (this.windSpeed * 3.6).toFixed(2) + ' km/h';
            }
            if (this.unit == 'nm/h') {
                this._container.children[1].textContent = (this.windSpeed * 1.9438444924406).toFixed(2) + ' nm/h';
            }
        } else {
            this._container.children[1].textContent = strings.wind_loading;
        }
    }

    onRemove() {
        this._map = undefined;
        this._container.parentNode.removeChild(this._container);
    }

    getWeatherInfo() {
        const center = map.getCenter();
        fetch('https://api.openweathermap.org/data/2.5/weather?lat=' + center.lat + '&lon=' + center.lng + '&units=metric&appid=' + openweatherApiKey)
        .then(response => response.json())
        .then(data => {
            this.windDeg = data.wind.deg;
            this.windSpeed = data.wind.speed;
            this.onUpdate();
        });
    }
}

map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.GeolocateControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');
map.addControl(new WindInfoControl(), 'top-right');

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
                    boatId: boat.id
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
                if (selectedBoatPopup != undefined) {
                    selectedBoatPopup.remove();
                }
                if (selectedBuoyPopup != undefined) {
                    selectedBuoyPopup.remove();
                }

                const pointProperties = event.features[0].properties;
                selectedBoat = boats.find(boat => boat.id == pointProperties.boatId);

                selectedBoatPopup = new mapboxgl.Popup()
                    .setLngLat([selectedBoat.positions[0].longitude, selectedBoat.positions[0].latitude])
                    .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + selectedBoat.name + '</h3>' +
                        '<div>' + strings.latitude + ': ' + selectedBoat.positions[0].latitude + '</div>' +
                        '<div>' + strings.longitude + ': ' + selectedBoat.positions[0].longitude + '</div>' +
                        '<div>' + strings.time + ': ' + new Date(selectedBoat.positions[0].created_at).toLocaleString('en-US') + '</div>'
                    )
                    .on('close', () => {
                        selectedBoat = undefined;
                        selectedBoatPopup = undefined;
                    })
                    .addTo(map);
            });

            map.on('mouseenter', 'boat_points', mapMouseEnter);
            map.on('mouseleave', 'boat_points', mapMouseLeave);
        }
    }

    // Selected boat popup
    if (selectedBoatPopup != undefined) {
        selectedBoatPopup.setLngLat([selectedBoat.positions[0].longitude, selectedBoat.positions[0].latitude]);

        const content = selectedBoatPopup.getElement().children[1];
        content.children[1].textContent = strings.latitude + ': ' + selectedBoat.positions[0].latitude
        content.children[2].textContent = strings.longitude + ': ' + selectedBoat.positions[0].longitude;
        content.children[3].textContent = strings.time + ': ' + new Date(selectedBoat.positions[0].created_at).toLocaleString('en-US');
    }

    // Buoy points
    if (buoysChanged) {
        buoysChanged = false;

        const buoyPoints = {
            type: 'FeatureCollection',
            features: buoys.filter(buoy => buoy.positions.length > 0).map(buoy => ({
                type: 'Feature',
                properties: {
                    buoyId: buoy.id
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
                if (selectedBoatPopup != undefined) {
                    selectedBoatPopup.remove();
                }
                if (selectedBuoyPopup != undefined) {
                    selectedBuoyPopup.remove();
                }

                const pointProperties = event.features[0].properties;
                selectedBuoy = buoys.find(buoy => buoy.id == pointProperties.buoyId);

                selectedBuoyPopup = new mapboxgl.Popup()
                    .setLngLat([selectedBuoy.positions[0].longitude, selectedBuoy.positions[0].latitude])
                    .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + selectedBuoy.name + '</h3>' +
                        '<div>' + strings.latitude + ': ' + selectedBuoy.positions[0].latitude + '</div>' +
                        '<div>' + strings.longitude + ': ' + selectedBuoy.positions[0].longitude + '</div>' +
                        '<div>' + strings.time + ': ' + new Date(selectedBuoy.positions[0].created_at).toLocaleString('en-US') + '</div>'
                    )
                    .on('close', () => {
                        selectedBuoy = undefined;
                        selectedBuoyPopup = undefined;
                    })
                    .addTo(map);
            });

            map.on('mouseenter', 'buoy_points', mapMouseEnter);
            map.on('mouseleave', 'buoy_points', mapMouseLeave);
        }
    }

    // Selected buoy popup
    if (selectedBuoyPopup != undefined) {
        selectedBuoyPopup.setLngLat([selectedBuoy.positions[0].longitude, selectedBuoy.positions[0].latitude]);

        const content = selectedBuoyPopup.getElement().children[1];
        content.children[1].textContent = strings.latitude + ': ' + selectedBuoy.positions[0].latitude
        content.children[2].textContent = strings.longitude + ': ' + selectedBuoy.positions[0].longitude;
        content.children[3].textContent = strings.time + ': ' + new Date(selectedBuoy.positions[0].created_at).toLocaleString('en-US');
    }
}

map.on('load', () => {
    // Add map items
    updateMapItems();
});

// Connect to websocket server
let isFirstWebSocketError = true;
let messageControl = undefined;
function connectToWebSocketServer() {
    const ws = new WebSocket(websocketsUrl);

    ws.onopen = () => {
        log('WebSocket connected!');

        if (messageControl != undefined) {
            map.removeControl(messageControl);
            messageControl = undefined;
        }
    };

    ws.onmessage = event => {
        const data = JSON.parse(event.data);
        log('Websocket message: ' + event.data);

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
        log('WebSocket disconnected, try to reconnect in ' + (websocketsReconnectTimeout / 1000) + ' seconds!');
        setTimeout(connectToWebSocketServer, websocketsReconnectTimeout);
    };

    ws.onerror = event => {
        if (isFirstWebSocketError) {
            isFirstWebSocketError = false;
            messageControl = new MessageControl(strings.connection_message)
            map.addControl(messageControl, 'top-left');
        }
    };
}
connectToWebSocketServer();
