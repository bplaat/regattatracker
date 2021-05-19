const type = window.data.type;
mapboxgl.accessToken = window.data.mapboxAccessToken;
const positions = window.data.positions;
const link = window.data.link;
const strings = window.data.strings;

function isDarkModeEnabled() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

const map = new mapboxgl.Map({
    container: 'map-container',
    style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
    center: [positions[0].longitude, positions[0].latitude],
    zoom: 12,
    attributionControl: false
});

map.addControl(new mapboxgl.ScaleControl(), 'bottom-left');
map.addControl(new mapboxgl.NavigationControl(), 'bottom-right');
map.addControl(new mapboxgl.GeolocateControl(), 'bottom-right');
map.addControl(new mapboxgl.FullscreenControl(), 'bottom-right');

map.on('load', () => {
    // Add line and points when there are old positions
    if (positions.length > 1) {
        // Positions line layer
        map.addSource('positions_line', {
            type: 'geojson',
            data: {
                type: 'Feature',
                geometry: {
                    type: 'LineString',
                    coordinates: positions.map(position =>
                        [position.longitude, position.latitude]
                    )
                }
            }
        });

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
        });

        // Old positions points layer
        map.addSource('old_position_points', {
            type: 'geojson',
            data: {
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
            }
        });

        map.addLayer({
            id: 'old_position_points',
            source: 'old_position_points',
            type: 'circle',
            paint: {
                'circle-color': '#a2a2a2',
                'circle-radius': 6
            }
        });

        map.on('click', 'old_position_points', event => {
            const position = JSON.parse(event.features[0].properties.position);

            new mapboxgl.Popup()
                .setLngLat([position.longitude, position.latitude])
                .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + strings.name.replace(':item_position.id', position.id) + '</h3>' +
                    '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                    '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                    '<div>' + strings.time + ': ' + new Date(position.created_at).toLocaleString('en-US') + '</div>' +
                    '<div><a href="' + link + '/' + position.id + '/edit">' + strings.edit_button + '</a> ' +
                        '<a href="' + link + '/' + position.id + '/delete">' + strings.delete_button + '</a></div>'
                )
                .addTo(map);
        });
    }

    // Current position layer
    map.addSource('current_position_point', {
        type: 'geojson',
        data: {
            type: 'Feature',
            properties: {
                position: positions[0]
            },
            geometry: {
                type: 'Point',
                coordinates: [positions[0].longitude, positions[0].latitude]
            }
        }
    });

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
                '<div><a href="' + link + '/' + position.id + '/edit">' + strings.edit_button + '</a> ' +
                    '<a href="' + link + '/' + position.id + '/delete">' + strings.delete_button + '</a></div>'
            )
            .addTo(map);
    });

    // Handle mouse hover events on items
    function mapMouseEnter(event) {
        map.getCanvas().style.cursor = 'pointer';
        map.getCanvas().title = event.lngLat.lat + ', ' + event.lngLat.lng;
    }
    map.on('mouseenter', 'current_position_point', mapMouseEnter);
    map.on('mouseenter', 'old_position_points', mapMouseEnter);

    function mapMouseLeave() {
        map.getCanvas().style.cursor = '';
        map.getCanvas().title = '';
    }
    map.on('mouseleave', 'current_position_point', mapMouseLeave);
    map.on('mouseleave', 'old_position_points', mapMouseLeave);
});
