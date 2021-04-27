mapboxgl.accessToken = window.data.mapboxAccessToken;

const positions = window.data.positions;
const lastPosition = positions[positions.length - 1];

const strings = window.data.strings;

function isDarkModeEnabled() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

const map = new mapboxgl.Map({
    container: 'map-container',
    style: isDarkModeEnabled() ? 'mapbox://styles/mapbox/dark-v10' : 'mapbox://styles/mapbox/light-v10',
    center: [lastPosition.longitude, lastPosition.latitude],
    zoom: 12,
    attributionControl: false
});

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
                features: positions.slice(0, -1).map(position => ({
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
                .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + strings.title + ' #' + position.id + '</h3>' +
                    '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                    '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                    '<div>' + strings.time + ': ' + new Date(position.updated_at).toLocaleString('en-US') + '</div>' +
                    '<div><a href="#">' + strings.edit + '</a> <a href="#">' + strings.delete + '</a></div>'
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
                position: lastPosition
            },
            geometry: {
                type: 'Point',
                coordinates: [lastPosition.longitude, lastPosition.latitude]
            }
        }
    });

    map.addLayer({
        id: 'current_position_point',
        source: 'current_position_point',
        type: 'circle',
        paint: {
            'circle-color': 'rgb(246, 140, 30)',
            'circle-radius': 10,
            'circle-stroke-width': 2,
            'circle-stroke-color': 'rgb(245, 198, 147)'
        }
    });

    map.on('click', 'current_position_point', event => {
        const position = JSON.parse(event.features[0].properties.position);

        new mapboxgl.Popup()
            .setLngLat([position.longitude, position.latitude])
            .setHTML('<h3 style="font-weight: bold; font-size: 18px; margin-bottom: 4px;">' + strings.title + ' #' + position.id + '</h3>' +
                '<div><b>' + strings.current + '</b></div>' +
                '<div>' + strings.latitude + ': ' + position.latitude + '</div>' +
                '<div>' + strings.longitude + ': ' + position.longitude + '</div>' +
                '<div>' + strings.time + ': ' + new Date(position.updated_at).toLocaleString('en-US') + '</div>' +
                '<div><a href="#">' + strings.edit + '</a> <a href="#">' + strings.delete + '</a></div>'
            )
            .addTo(map);
    });

    // Handle mouse hover events
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
