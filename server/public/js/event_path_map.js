const csrfToken = window.data.csrfToken;
const apiKey = window.data.apiKey;
const apiToken = window.data.apiToken;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const event = window.data.event;
const path = window.data.path;
const link = window.data.link;

// Default path points
if (path.length == 0) {
    path.push([ 4.7, 52 ]);
    path.push([ 4.71, 52.01 ]);
}

function isDarkModeEnabled() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

const bounds = path.reduce(function (bounds, point) {
    return bounds.extend(point);
}, new mapboxgl.LngLatBounds(path[0], path[0]));

const map = new mapboxgl.Map({
    container: 'map-container',
    style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
    bounds: bounds,
    attributionControl: false
});

function updateMapItems() {
    // Path line layer
    const pathLine = {
        type: 'Feature',
        geometry: {
            type: 'LineString',
            coordinates: path.concat([path[0]])
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
        });
    }
}

const addButton = document.getElementById('add-button');
const saveButton = document.getElementById('save-button');

map.on('load', () => {
    updateMapItems();

    // Add path makers (Ugly)
    for (let i = 0; i < path.length; i++) {
        const marker = new mapboxgl.Marker({
            draggable: true
        })
        .setLngLat(path[i])
        .on('drag', event => {
            path[event.target.data] = [ event.target.getLngLat().lng, event.target.getLngLat().lat ];
            updateMapItems();
        })
        .addTo(map);
        marker.data = i;
    }

    // Add button click listener
    addButton.addEventListener('click', () => {
        path.push([
            path[path.length - 1][0],
            path[path.length - 1][1] - 0.0005
        ]);
        updateMapItems();

        // Add new path marker (Ugly)
        const marker = new mapboxgl.Marker({
            draggable: true
        })
        .setLngLat(path[path.length - 1])
        .on('drag', event => {
            path[event.target.data] = [ event.target.getLngLat().lng, event.target.getLngLat().lat ];
            updateMapItems();
        })
        .addTo(map);
        marker.data = path.length - 1;
    });

    // Save button click listener
    saveButton.addEventListener('click', () => {
        const xhr = new XMLHttpRequest();
        xhr.onload = () => {
            alert('Path saved!');
        };
        xhr.open('POST', link, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        xhr.setRequestHeader('Authorization', 'Bearer ' + apiToken);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('api_key=' + apiKey + '&path=' + JSON.stringify(path));
    });
});
