<?php

return [
    // Admin buoys index page
    'index.title' => 'Buoys - Admin',
    'index.breadcrumb' => 'Buoys',
    'index.header' => 'All the buoys',
    'index.query_placeholder' => 'Search for buoys...',
    'index.search_button' => 'Search',
    'index.empty' => 'There are no buoys found',
    'index.create_button' => 'Create new buoy',

    // Admin buoys create page
    'create.title' => 'Create - Buoys - Admin',
    'create.breadcrumb' => 'Create',
    'create.header' => 'Create new buoy',
    'create.name' => 'Name',
    'create.description' => 'Description',
    'create.create_button' => 'Create new buoy',

    // Admin buoys show page
    'show.title' => ':buoy.name - Buoys - Admin',
    'show.track_button' => 'Track buoy',
    'show.edit_button' => 'Edit buoy',
    'show.delete_button' => 'Delete buoy',

    'show.positions' => 'Buoy Positions',

    'show.positions_map_name' => 'Buoy Position #:item_position.id',
    'show.positions_map_current' => 'Current buoy position',
    'show.positions_map_latitude' => 'Latitude',
    'show.positions_map_longitude' => 'Longitude',
    'show.positions_map_time' => 'Time',
    'show.positions_map_edit_button' => 'Edit',
    'show.positions_map_delete_button' => 'Delete',

    'show.positions_empty' => 'This buoy has no known positions',
    'show.positions_previous_button' => '&laquo; Previous day',
    'show.positions_today_button' => 'Today',
    'show.positions_next_button' => 'Next day &raquo;',
    'show.positions_latitude_placeholder' => 'Latitude',
    'show.positions_longitude_placeholder' => 'Longitude',
    'show.positions_add_button' => 'Add position',

    // Admin buoys track page
    'track.title' => 'Track - :buoy.name - Buoys - Admin',
    'track.breadcrumb' => 'Track',

    'track.map_name' => 'Buoy Position #:item_position.id',
    'track.map_current' => 'Current buoy position',
    'track.map_latitude' => 'Latitude',
    'track.map_longitude' => 'Longitude',
    'track.map_time' => 'Time',
    'track.map_edit_button' => 'Edit',
    'track.map_delete_button' => 'Delete',

    'track.start_button' => 'Start tracking',
    'track.stop_button' => 'Stop tracking',
    'track.loading' => 'Loading...',
    'track.sending' => 'Sending in :seconds seconds...',
    'track.error_message' => 'Your browser doesn\'t support geolocation tracking!',

    // Admin buoys edit page
    'edit.title' => 'Edit - :buoy.name - Buoys - Admin',
    'edit.breadcrumb' => 'Edit',
    'edit.header' => 'Edit buoy',
    'edit.name' => 'Name',
    'edit.description' => 'Description',
    'edit.edit_button' => 'Edit buoy',

    // ### Buoy positions pages ###

    // Buoy positions index page
    'positions.index.breadcrumb' => 'Positions',

    // Buoy positions show page
    'positions.show.breadcrumb' => 'Buoy Position #:boat_position.id',

    // Buoy positions edit page
    'positions.edit.title' => 'Edit - Buoy Position #:boat_position.id - Positions - :buoy.name - Buoys - Admin',
    'positions.edit.breadcrumb' => 'Edit',
    'positions.edit.header' => 'Edit buoy position',
    'positions.edit.latitude' => 'Latitude',
    'positions.edit.longitude' => 'Longitude',
    'positions.edit.created_at_date' => 'Date',
    'positions.edit.created_at_time' => 'Time',
    'positions.edit.edit_button' => 'Edit buoy position'
];
