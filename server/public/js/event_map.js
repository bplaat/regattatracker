const csrfToken = window.data.csrfToken;
const apiKey = window.data.apiKey;
const apiToken = window.data.apiToken;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const event = window.data.event;
const link = window.data.link;
const strings = window.data.strings;

let pointIdCounter = 1;
const path = JSON.parse(event.path).map(point => ({ id: pointIdCounter++, lat: point[0], lng: point[1] }));
let selectedPointId = undefined;
let selectedPointPopup = undefined;

class EditorButtonsControl {
    onAdd(map) {
        this._map = map;
        this._container = document.createElement('div');
        this._container.className = 'mapboxgl-ctrl mapboxgl-ctrl-group';
        this._container.innerHTML = `
            <button type="button" title="${strings.add_point}">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M9,11.5A2.5,2.5 0 0,0 11.5,9A2.5,2.5 0 0,0 9,6.5A2.5,2.5 0 0,0 6.5,9A2.5,2.5 0 0,0 9,11.5M9,2C12.86,2 16,5.13 16,9C16,14.25 9,22 9,22C9,22 2,14.25 2,9A7,7 0 0,1 9,2M15,17H18V14H20V17H23V19H20V22H18V19H15V17Z" />
                </svg>
            </button>

            <button type="button" title="${strings.add_finish}">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M17,14H19V17H22V19H19V22H17V19H14V17H17V14M12.4,5H18V12C15.78,12 13.84,13.21 12.8,15H11L10.6,13H5V20H3V3H12L12.4,5Z" />
                </svg>
            </button>

            <button type="button" title="${strings.save}">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />
                </svg>
            </button>
        `;
        this._container.children[0].addEventListener('click', this.addPoint);
        this._container.children[1].addEventListener('click', this.addFinish);
        this._container.children[2].addEventListener('click', this.save);
        return this._container;
    }

    onRemove() {
        this._map = undefined;
        this._container.parentNode.removeChild(this._container);
    }

    addPoint() {
        if (path.length > 0 && selectedPointId == undefined) {
            selectedPointId = path[path.length - 1].id;
        }

        if (selectedPointId != undefined) {
            for (let i = 0; i < path.length; i++) {
                const point = path[i];
                if (point.id == selectedPointId) {
                    const newId = pointIdCounter++;
                    path.splice(i + 1, 0, { id: newId, lat: point.lat - 0.0001, lng: point.lng });
                    selectedPointId = newId;
                    break;
                }
            }
        } else {
            const center = map.getCenter();
            path.push({ id: pointIdCounter++, lat: center.lat, lng: center.lng });
        }

        updateMapItems();
    }

    addFinish() {
        alert('Todo!');
    }

    save() {
        const xhr = new XMLHttpRequest();
        xhr.onload = () => {
            alert('Event map saved!');
        };
        xhr.open('POST', link, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Authorization', 'Bearer ' + apiToken);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('api_key=' + apiKey + '&path=' + JSON.stringify(path.map(point => [point.lat, point.lng])));
    }
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

if (path.length > 0) {
    const points = path.map(point => [point.lng, point.lat]);
    const bounds = points.reduce(function (bounds, point) {
        return bounds.extend(point);
    }, new mapboxgl.LngLatBounds(points[0], points[0]));
    map.fitBounds(bounds, { animate: false, padding: 50 });
}

map.addControl(new EditorButtonsControl(), 'top-left');
map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.GeolocateControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');

function pointOnMove(event) {
    map.getCanvas().style.cursor = 'grabbing';

    const point = path.find(point => point.id == selectedPointId);
    point.lat = event.lngLat.lat;
    point.lng = event.lngLat.lng;
    updateMapItems();
}

function pointMouseEnter(event) {
    map.getCanvas().style.cursor = 'move';
    map.getCanvas().title = event.lngLat.lat + ', ' + event.lngLat.lng;
}

function pointMouseLeave(event) {
    map.getCanvas().style.cursor = '';
    map.getCanvas().title = '';
}

function pointMouseDown(event) {
    event.preventDefault();

    selectedPointId = JSON.parse(map.queryRenderedFeatures(event.point)[0].properties.point).id;
    updateMapItems();

    map.getCanvas().style.cursor = 'grab';
    map.on('mousemove', pointOnMove);

    map.once('mouseup', () => {
        map.getCanvas().style.cursor = '';
        map.off('mousemove', pointOnMove)
    });
}

function pointTouchStart(event) {
    if (event.points.length != 1) return;
    event.preventDefault();

    selectedPointId = JSON.parse(map.queryRenderedFeatures(event.point)[0].properties.point).id;
    updateMapItems();

    map.on('touchmove', pointOnMove);

    map.once('touchend', () => {
        map.getCanvas().style.cursor = '';
        map.off('touchmove', pointOnMove);
    });
}

function updateMapItems() {
    // Path points layer
    const pathSelectedPoint = {
        type: 'FeatureCollection',
        features: path.filter(point => point.id == selectedPointId).map(point => ({
            type: 'Feature',
            properties: {
                point: point
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
        });

        map.on('dblclick', 'path_selected_point', function (event) {
            event.preventDefault();

            const point = path.find(point => point.id == selectedPointId);

            selectedPointPopup = new mapboxgl.Popup()
                .setLngLat([point.lng, point.lat])
                .setHTML(`
                    <label>${strings.latitude}:</label>
                    <input value="${point.lat}">
                    <label>${strings.longitude}:</label>
                    <input value="${point.lng}">
                `)
                .on('close', () => {
                    selectedPointPopup = undefined;
                })
                .addTo(map);

            const content = selectedPointPopup.getElement().children[1];
            content.children[1].addEventListener('change', event => {
                const point = path.find(point => point.id == selectedPointId);
                point.lat = parseFloat(event.target.value);
                updateMapItems();
            });
            content.children[3].addEventListener('change', event => {
                const point = path.find(point => point.id == selectedPointId);
                point.lng = parseFloat(event.target.value);
                updateMapItems();
            });
        });

        map.on('mouseenter', 'path_selected_point', pointMouseEnter);
        map.on('mouseleave', 'path_selected_point', pointMouseLeave);
        map.on('mousedown', 'path_selected_point', pointMouseDown);
        map.on('touchstart', 'path_selected_point', pointTouchStart);
    }

    // Path points layer
    const pathPoints = {
        type: 'FeatureCollection',
        features: path.filter(point => point.id != selectedPointId).map(point => ({
            type: 'Feature',
            properties: {
                point: point
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
        map.on('touchstart', 'path_points', pointTouchStart);
    }

    // Path line layer
    const pathLine = {
        type: 'Feature',
        geometry: {
            type: 'LineString',
            coordinates: path.map(point => [point.lng, point.lat])
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

    // Selected point popup
    if (selectedPointPopup != undefined) {
        const point = path.find(point => point.id == selectedPointId);
        selectedPointPopup.setLngLat([point.lng, point.lat]);

        const content = selectedPointPopup.getElement().children[1];
        content.children[1].value = point.lat;
        content.children[3].value = point.lng;
    }
}

map.on('load', updateMapItems);
