const csrfToken = window.data.csrfToken;
const apiKey = window.data.apiKey;
const apiToken = window.data.apiToken;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const event = window.data.event;
const links = window.data.links;
const strings = window.data.strings;

let finishes = event.finishes.map(finish => {
    finish.latitude_a = parseFloat(finish.latitude_a);
    finish.longitude_a = parseFloat(finish.longitude_a);
    finish.latitude_b = parseFloat(finish.latitude_b);
    finish.longitude_b = parseFloat(finish.longitude_b);
    return finish;
});
let selectedFinish = undefined;
let selectedFinishSide = undefined;
let selectedFinishPopup = undefined;

let pointIdCounter = 1;
let path = JSON.parse(event.path).map(point => ({ id: pointIdCounter++, lat: point[0], lng: point[1] }));
let selectedPoint = undefined;
let selectedPointPopup = undefined;

let finishesChanged = true;
let pathChanged = true;

class EditorButtonsControl {
    onAdd(map) {
        this._map = map;

        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
        this._container.innerHTML = `
            <button type="button" title="${strings.add_point_button}">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9,11.5A2.5,2.5 0 0,0 11.5,9A2.5,2.5 0 0,0 9,6.5A2.5,2.5 0 0,0 6.5,9A2.5,2.5 0 0,0 9,11.5M9,2C12.86,2 16,5.13 16,9C16,14.25 9,22 9,22C9,22 2,14.25 2,9A7,7 0 0,1 9,2M15,17H18V14H20V17H23V19H20V22H18V19H15V17Z" />
                </svg>
            </button>

            <button type="button"></button>

            <button type="button" title="${strings.add_finish_button}">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M17,14H19V17H22V19H19V22H17V19H14V17H17V14M12.4,5H18V12C15.78,12 13.84,13.21 12.8,15H11L10.6,13H5V20H3V3H12L12.4,5Z" />
                </svg>
            </button>
        `;
        this.onUpdate();

        this._container.children[0].addEventListener('click', this.addPoint.bind(this));
        this._container.children[1].addEventListener('click', this.toggleConnected.bind(this));
        this._container.children[2].addEventListener('click', this.addFinish.bind(this));

        return this._container;
    }

    onUpdate() {
        if (event.connected == 1) {
            this._container.children[1].title = strings.disconnect_button;
            this._container.children[1].innerHTML = `<svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M10.59,13.41C11,13.8 11,14.44 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C7.22,12.88 7.22,9.71 9.17,7.76V7.76L12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.59,9.17C9.41,10.34 9.41,12.24 10.59,13.41M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.78,11.12 16.78,14.29 14.83,16.24V16.24L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L13.41,14.83C14.59,13.66 14.59,11.76 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
            </svg>`;
        } else {
            this._container.children[1].title = strings.connect_button;
            this._container.children[1].innerHTML = `<svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M2,5.27L3.28,4L20,20.72L18.73,22L13.9,17.17L11.29,19.78C9.34,21.73 6.17,21.73 4.22,19.78C2.27,17.83 2.27,14.66 4.22,12.71L5.71,11.22C5.7,12.04 5.83,12.86 6.11,13.65L5.64,14.12C4.46,15.29 4.46,17.19 5.64,18.36C6.81,19.54 8.71,19.54 9.88,18.36L12.5,15.76L10.88,14.15C10.87,14.39 10.77,14.64 10.59,14.83C10.2,15.22 9.56,15.22 9.17,14.83C8.12,13.77 7.63,12.37 7.72,11L2,5.27M12.71,4.22C14.66,2.27 17.83,2.27 19.78,4.22C21.73,6.17 21.73,9.34 19.78,11.29L18.29,12.78C18.3,11.96 18.17,11.14 17.89,10.36L18.36,9.88C19.54,8.71 19.54,6.81 18.36,5.64C17.19,4.46 15.29,4.46 14.12,5.64L10.79,8.97L9.38,7.55L12.71,4.22M13.41,9.17C13.8,8.78 14.44,8.78 14.83,9.17C16.2,10.54 16.61,12.5 16.06,14.23L14.28,12.46C14.23,11.78 13.94,11.11 13.41,10.59C13,10.2 13,9.56 13.41,9.17Z" />
            </svg>`;
        }
    }

    onRemove() {
        this._map = undefined;
        this._container.parentNode.removeChild(this._container);
    }

    addPoint() {
        if (path.length > 0 && selectedPoint == undefined) {
            selectedPoint = path[path.length - 1];
        }

        if (selectedPoint != undefined) {
            for (let i = 0; i < path.length; i++) {
                const point = path[i];
                if (point.id == selectedPoint.id) {
                    selectedPoint = { id: pointIdCounter++, lat: point.lat, lng: point.lng };
                    path.splice(i + 1, 0, selectedPoint);
                    break;
                }
            }
        } else {
            const center = map.getCenter();
            path.push({ id: pointIdCounter++, lat: center.lat, lng: center.lng });
        }
        updateEvent();

        pathChanged = true;
        updateMapItems();
    }

    toggleConnected() {
        event.connected = event.connected == 1 ? 0 : 1;
        this.onUpdate();

        pathChanged = true;
        updateMapItems();
    }

    addFinish() {
        const center = map.getCenter();
        storeEventFinish({
            latitude_a: center.lat,
            longitude_a: center.lng,
            latitude_b: center.lat,
            longitude_b: center.lng
        });
    }
}

class PathLengthControl {
    onAdd(map) {
        this._map = map;

        this.unit = localStorage.distance_unit || 'm';

        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
        this._container.style = 'padding: 4px 8px; cursor: pointer; user-select: none;';
        this._container.innerHTML = `<p></p>`;
        this.onUpdate();

        this._container.addEventListener('click', () => {
            if (this.unit == 'm') {
                this.unit = 'nm';
            } else {
                this.unit = 'm';
            }
            localStorage.distance_unit = this.unit;
            this.onUpdate();
        });

        return this._container;
    }

    onUpdate() {
        if (path.length >= 2) {
            const line = turf.lineString((event.connected == 1 ? path.concat([path[0]]) : path).map(point => [ point.lng, point.lat ]));
            let length = turf.length(line, { units: 'kilometers' });
            if (this.unit == 'm') {
                this._container.children[0].textContent = strings.path_length + ' ' + (length >= 1 ? length.toFixed(2) + ' km' : (length * 1000).toFixed(0) + ' m');
            }
            if (this.unit == 'nm') {
                length *= 0.53995680;
                this._container.children[0].textContent = strings.path_length + ' ' + length.toFixed(length >= 1 ? 2 : 3) + ' nm';
            }
        } else {
            this._container.children[0].textContent = strings.path_length_message;
        }
    }

    onRemove() {
        this._map = undefined;
        this._container.parentNode.removeChild(this._container);
    }
}

function updateEvent() {
    fetch(links.apiEventsUpdate.replace('{event}', event.id), {
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + apiToken,
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'api_key=' + apiKey + '&name=' + event.name + '&start=' + (event.start != null ? event.start.split('T')[0] : '')  +
            '&end=' + (event.end != null ? event.end.split('T')[0] : '') + '&connected=' + event.connected +
            '&path=' + JSON.stringify(path.map(point => [point.lat, point.lng]))
    });
}

function storeEventFinish(finish) {
    fetch(links.apiEventFinishesStore.replace('{event}', event.id), {
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + apiToken,
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'api_key=' + apiKey + '&latitude_a=' +  finish.latitude_a.toFixed(8) + '&longitude_a=' +  finish.longitude_a.toFixed(8) +
            '&latitude_b=' + finish.latitude_b.toFixed(8) + '&longitude_b=' +  finish.longitude_b.toFixed(8)
    })
    .then(response => response.json())
    .then(data => {
        const finish = data;
        finish.latitude_a = parseFloat(finish.latitude_a);
        finish.longitude_a = parseFloat(finish.longitude_a);
        finish.latitude_b = parseFloat(finish.latitude_b);
        finish.longitude_b = parseFloat(finish.longitude_b);
        finishes.push(finish);

        finishesChanged = true;
        updateMapItems();
    });
}

function updateEventFinish(finishId) {
    const finish = finishes.find(finish => finish.id == finishId);

    fetch(links.apiEventFinishesUpdate.replace('{event}', event.id).replace('{eventFinish}', finish.id), {
        method: 'post',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + apiToken,
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'api_key=' + apiKey + '&latitude_a=' + finish.latitude_a.toFixed(8) + '&longitude_a=' + finish.longitude_a.toFixed(8) +
            '&latitude_b=' + finish.latitude_b.toFixed(8) + '&longitude_b=' + finish.longitude_b.toFixed(8)
    });
}

function deleteEventFinish(finishId) {
    const finish = finishes.find(finish => finish.id == finishId);

    fetch(links.apiEventFinishesDelete.replace('{event}', event.id).replace('{eventFinish}', finish.id) + '?api_key=' + apiKey, {
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Authorization': 'Bearer ' + apiToken,
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    });

    finishes = finishes.filter(finish => finish.id != finishId);

    finishesChanged = true;
    updateMapItems();
}

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

if (path.length > 0 || finishes.length > 0) {
    const points = path.map(point => [point.lng, point.lat])
        .concat(finishes.map(finish => [finish.longitude_a, finish.latitude_a]))
        .concat(finishes.map(finish => [finish.longitude_b, finish.latitude_b]));

    const bounds = points.reduce(function (bounds, point) {
        return bounds.extend(point);
    }, new mapboxgl.LngLatBounds(points[0], points[0]));
    map.fitBounds(bounds, { animate: false, padding: 50 });
}

map.addControl(new EditorButtonsControl(), 'top-left');
const pathLengthControl = new PathLengthControl();
map.addControl(pathLengthControl, 'top-right');
map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.GeolocateControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');

// General point mouse hover
function pointMouseEnter(event) {
    map.getCanvas().style.cursor = 'move';
    map.getCanvas().title = event.lngLat.lat + ', ' + event.lngLat.lng;
}

function pointMouseLeave(event) {
    map.getCanvas().style.cursor = '';
    map.getCanvas().title = '';
}

// Finish point dragging
function finishOnMove(event) {
    map.getCanvas().style.cursor = 'grabbing';

    if (selectedFinishSide == 'a') {
        selectedFinish.latitude_a = event.lngLat.lat;
        selectedFinish.longitude_a = event.lngLat.lng;
    }
    if (selectedFinishSide == 'b') {
        selectedFinish.latitude_b = event.lngLat.lat;
        selectedFinish.longitude_b = event.lngLat.lng;
    }

    finishesChanged = true;
    updateMapItems();
}

let finishMouseDownFired = false;
function finishMouseDown(event) {
    event.preventDefault();
    if (event.originalEvent.button == 0 && !finishMouseDownFired) {
        finishMouseDownFired = true;

        const pointProperties = map.queryRenderedFeatures(event.point)[0].properties;
        selectedFinish = finishes.find(finish => finish.id == pointProperties.finishId);
        selectedFinishSide = pointProperties.side;

        finishesChanged = true;
        updateMapItems();

        map.getCanvas().style.cursor = 'grab';
        map.on('mousemove', finishOnMove);

        map.once('mouseup', () => {
            finishMouseDownFired = false;

            map.getCanvas().style.cursor = '';
            map.off('mousemove', finishOnMove);

            updateEventFinish(selectedFinish.id);
        });
    }
}

// Path point dragging
function pointOnMove(event) {
    map.getCanvas().style.cursor = 'grabbing';

    selectedPoint.lat = event.lngLat.lat;
    selectedPoint.lng = event.lngLat.lng;

    pathChanged = true;
    updateMapItems();
}

let pointMouseDownFired = false;
function pointMouseDown(event) {
    event.preventDefault();
    if (event.originalEvent.button == 0 && !pointMouseDownFired) {
        pointMouseDownFired = true;

        const pointProperties = map.queryRenderedFeatures(event.point)[0].properties;
        selectedPoint = path.find(point => point.id == pointProperties.pointId);

        pathChanged = true;
        updateMapItems();

        map.getCanvas().style.cursor = 'grab';
        map.on('mousemove', pointOnMove);

        map.once('mouseup', () => {
            pointMouseDownFired = false;

            map.getCanvas().style.cursor = '';
            map.off('mousemove', pointOnMove);

            updateEvent();
        });
    }
}

function updateMapItems() {
    // Finishes
    if (finishesChanged) {
        finishesChanged = false;

        // Selected finish points layer
        const finishSelectedPoint = {
            type: 'FeatureCollection',
            features: finishes.filter(finish => finish.id == selectedFinish?.id && selectedFinishSide == 'a').map(finish => ({
                type: 'Feature',
                properties: {
                    finishId: finish.id,
                    side: 'a'
                },
                geometry: {
                    type: 'Point',
                    coordinates: [finish.longitude_a, finish.latitude_a]
                }
            })).concat(finishes.filter(finish => finish.id == selectedFinish?.id && selectedFinishSide == 'b').map(finish => ({
                type: 'Feature',
                properties: {
                    finishId: finish.id,
                    side: 'b'
                },
                geometry: {
                    type: 'Point',
                    coordinates: [finish.longitude_b, finish.latitude_b]
                }
            })))
        };

        if (map.getSource('finish_selected_points') != undefined) {
            map.getSource('finish_selected_points').setData(finishSelectedPoint);
        } else {
            map.addSource('finish_selected_points', { type: 'geojson', data: finishSelectedPoint });

            map.addLayer({
                id: 'finish_selected_points',
                source: 'finish_selected_points',
                type: 'circle',
                paint: {
                    'circle-color': 'rgb(246, 140, 30)',
                    'circle-radius': 10,
                    'circle-stroke-width': 2,
                    'circle-stroke-color': 'rgb(245, 198, 147)'
                }
            });

            map.on('contextmenu', 'finish_selected_points', function (event) {
                event.preventDefault();
                if (selectedFinishPopup == undefined) {
                    selectedFinishPopup = new mapboxgl.Popup()
                        .setLngLat(selectedFinishSide == 'a' ?
                            [selectedFinish.longitude_a, selectedFinish.latitude_a] :
                            [selectedFinish.longitude_b, selectedFinish.latitude_b]
                        )
                        .setHTML(`
                            <label>${strings.latitude}:</label>
                            <input value="${selectedFinishSide == 'a' ? selectedFinish.latitude_a : selectedFinish.latitude_b}" style="margin-bottom: 8px;">
                            <label>${strings.longitude}:</label>
                            <input value="${selectedFinishSide == 'a' ? selectedFinish.longitude_a : selectedFinish.longitude_b}" style="margin-bottom: 8px;">
                            <button>${strings.delete_button}</button>
                        `)
                        .on('close', () => {
                            selectedFinishPopup = undefined;
                        })
                        .addTo(map);

                    const content = selectedFinishPopup.getElement().children[1];

                    content.children[1].addEventListener('change', event => {
                        if (selectedFinishSide == 'a') {
                            selectedFinish.latitude_a = parseFloat(event.target.value);
                        }
                        if (selectedFinishSide == 'b') {
                            selectedFinish.latitude_b = parseFloat(event.target.value);
                        }
                        updateEventFinish(selectedFinish.id);

                        finishesChanged = true;
                        updateMapItems();
                    });

                    content.children[3].addEventListener('change', event => {
                        if (selectedFinishSide == 'a') {
                            selectedFinish.longitude_a = parseFloat(event.target.value);
                        }
                        if (selectedFinishSide == 'b') {
                            selectedFinish.longitude_b = parseFloat(event.target.value);
                        }
                        updateEventFinish(selectedFinish.id);

                        finishesChanged = true;
                        updateMapItems();
                    });

                    content.children[4].addEventListener('click', event => {
                        selectedFinishPopup.remove();
                        selectedFinishPopup = undefined;

                        deleteEventFinish(selectedFinish.id);
                        selectedFinish = undefined;

                        finishesChanged = true;
                        updateMapItems();
                    });
                }
            });

            map.on('mouseenter', 'finish_selected_points', pointMouseEnter);
            map.on('mouseleave', 'finish_selected_points', pointMouseLeave);
            map.on('mousedown', 'finish_selected_points', finishMouseDown);
        }

        // Finish points layer
        const finishPoints = {
            type: 'FeatureCollection',
            features: finishes.filter(finish => !(finish.id == selectedFinish?.id && selectedFinishSide == 'a')).map(finish => ({
                type: 'Feature',
                properties: {
                    finishId: finish.id,
                    side: 'a'
                },
                geometry: {
                    type: 'Point',
                    coordinates: [finish.longitude_a, finish.latitude_a]
                }
            })).concat(finishes.filter(finish => !(finish.id == selectedFinish?.id && selectedFinishSide == 'b')).map(finish => ({
                type: 'Feature',
                properties: {
                    finishId: finish.id,
                    side: 'b'
                },
                geometry: {
                    type: 'Point',
                    coordinates: [finish.longitude_b, finish.latitude_b]
                }
            })))
        };

        if (map.getSource('finish_points') != undefined) {
            map.getSource('finish_points').setData(finishPoints);
        } else {
            map.addSource('finish_points', { type: 'geojson', data: finishPoints });

            map.addLayer({
                id: 'finish_points',
                source: 'finish_points',
                type: 'circle',
                paint: {
                    'circle-color': '#ff0',
                    'circle-radius': 6
                }
            }, 'finish_selected_points');

            map.on('mouseenter', 'finish_points', pointMouseEnter);
            map.on('mouseleave', 'finish_points', pointMouseLeave);
            map.on('mousedown', 'finish_points', finishMouseDown);
        }

        // Finish lines layer
        const finishLines = {
            type: 'FeatureCollection',
            features: finishes.map(finish => ({
                type: 'Feature',
                geometry: {
                    type: 'LineString',
                    coordinates: [
                        [finish.longitude_a, finish.latitude_a],
                        [finish.longitude_b, finish.latitude_b]
                    ]
                }
            }))
        };

        if (map.getSource('finish_lines') != undefined) {
            map.getSource('finish_lines').setData(finishLines);
        } else {
            map.addSource('finish_lines', { type: 'geojson', data: finishLines });

            map.addLayer({
                id: 'finish_lines',
                source: 'finish_lines',
                type: 'line',
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#ff0',
                    'line-width': 4
                }
            }, 'finish_points');
        }
    }

    // Path
    if (pathChanged) {
        pathChanged = false;

        // Selected path points layer
        const pathSelectedPoint = {
            type: 'FeatureCollection',
            features: path.filter(point => point.id == selectedPoint?.id).map(point => ({
                type: 'Feature',
                properties: {
                    pointId: point.id
                },
                geometry: {
                    type: 'Point',
                    coordinates: [point.lng, point.lat]
                }
            }))
        };

        if (map.getSource('path_selected_point') != undefined) {
            map.getSource('path_selected_point').setData(pathSelectedPoint);
        } else {
            map.addSource('path_selected_point', { type: 'geojson', data: pathSelectedPoint });

            map.addLayer({
                id: 'path_selected_point',
                source: 'path_selected_point',
                type: 'circle',
                paint: {
                    'circle-color': 'rgb(50, 148, 209)',
                    'circle-radius': 10,
                    'circle-stroke-width': 2,
                    'circle-stroke-color': 'rgb(49, 206, 255)'
                }
            }, 'finish_lines');

            map.on('contextmenu', 'path_selected_point', function (event) {
                event.preventDefault();
                if (selectedPointPopup == undefined) {
                    selectedPointPopup = new mapboxgl.Popup()
                        .setLngLat([selectedPoint.lng, selectedPoint.lat])
                        .setHTML(`
                            <label>${strings.latitude}:</label>
                            <input value="${selectedPoint.lat}" style="margin-bottom: 8px;">
                            <label>${strings.longitude}:</label>
                            <input value="${selectedPoint.lng}" style="margin-bottom: 8px;">
                            <button>${strings.delete_button}</button>
                        `)
                        .on('close', () => {
                            selectedPointPopup = undefined;
                        })
                        .addTo(map);

                    const content = selectedPointPopup.getElement().children[1];

                    content.children[1].addEventListener('change', event => {
                        selectedPoint.lat = parseFloat(event.target.value);
                        updateEvent();

                        pathChanged = true;
                        updateMapItems();
                    });

                    content.children[3].addEventListener('change', event => {
                        selectedPoint.lng = parseFloat(event.target.value);
                        updateEvent();

                        pathChanged = true;
                        updateMapItems();
                    });

                    content.children[4].addEventListener('click', event => {
                        selectedPointPopup.remove();
                        selectedPointPopup = undefined;

                        path = path.filter(point => point.id != selectedPoint?.id);
                        updateEvent();
                        selectedPoint = undefined;

                        pathChanged = true;
                        updateMapItems();
                    });
                }
            });

            map.on('mouseenter', 'path_selected_point', pointMouseEnter);
            map.on('mouseleave', 'path_selected_point', pointMouseLeave);
            map.on('mousedown', 'path_selected_point', pointMouseDown);
        }

        // Path points layer
        const pathPoints = {
            type: 'FeatureCollection',
            features: path.filter(point => point.id != selectedPoint?.id).map(point => ({
                type: 'Feature',
                properties: {
                    pointId: point.id
                },
                geometry: {
                    type: 'Point',
                    coordinates: [point.lng, point.lat]
                }
            }))
        };

        if (map.getSource('path_points') != undefined) {
            map.getSource('path_points').setData(pathPoints);
        } else {
            map.addSource('path_points', { type: 'geojson', data: pathPoints });

            map.addLayer({
                id: 'path_points',
                source: 'path_points',
                type: 'circle',
                paint: {
                    'circle-color': '#a2a2a2',
                    'circle-radius': 6
                }
            }, 'path_selected_point');

            map.on('mouseenter', 'path_points', pointMouseEnter);
            map.on('mouseleave', 'path_points', pointMouseLeave);
            map.on('mousedown', 'path_points', pointMouseDown);
        }

        // Path line layer
        const pathLine = {
            type: 'Feature',
            geometry: {
                type: 'LineString',
                coordinates: path.length > 0 ? (event.connected == 1 ? path.concat([path[0]]) : path)
                    .map(point => [point.lng, point.lat]) : []
            }
        };

        if (map.getSource('path_line') != undefined) {
            map.getSource('path_line').setData(pathLine);
        } else {
            map.addSource('path_line', { type: 'geojson', data: pathLine });

            map.addLayer({
                id: 'path_line',
                source: 'path_line',
                type: 'line',
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#a2a2a2',
                    'line-width': 4
                }
            }, 'path_points');
        }

        // Update path length control
        pathLengthControl.onUpdate();
    }

    // Selected finish popup
    if (selectedFinishPopup != undefined) {
        selectedFinishPopup.setLngLat(selectedFinishSide == 'a' ?
            [selectedFinish.longitude_a, selectedFinish.latitude_a] :
            [selectedFinish.longitude_b, selectedFinish.latitude_b]);

        const content = selectedFinishPopup.getElement().children[1];
        content.children[1].value = selectedFinishSide == 'a' ? selectedFinish.latitude_a : selectedFinish.latitude_b;
        content.children[3].value = selectedFinishSide == 'a' ? selectedFinish.longitude_a : selectedFinish.longitude_b;
    }

    // Selected point popup
    if (selectedPointPopup != undefined) {
        selectedPointPopup.setLngLat([selectedPoint.lng, selectedPoint.lat]);

        const content = selectedPointPopup.getElement().children[1];
        content.children[1].value = selectedPoint.lat;
        content.children[3].value = selectedPoint.lng;
    }
}

map.on('load', updateMapItems);
