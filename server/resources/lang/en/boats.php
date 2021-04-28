<?php

return [
    // Boats index page
    'index.title' => 'Boats',
    'index.breadcrumb' => 'Boats',
    'index.header' => 'All your boats',
    'index.search_field' => 'Search for boats...',
    'index.search_button' => 'Search',
    'index.role_crew' => 'CREW',
    'index.role_captain' => 'CAPTAIN',
    'index.empty' => 'There are no boats found',
    'index.create' => 'Create new boat',

    // Boats create page
    'create.title' => 'Create - Boats',
    'create.breadcrumb' => 'Create',
    'create.header' => 'Create new boat',
    'create.name' => 'Name',
    'create.description' => 'Description',
    'create.mmsi' => 'MMSI',
    'create.length' => 'Length overall (m)',
    'create.breadth' => 'Breadth overall (m)',
    'create.weight' => 'Weight (kg)',
    'create.sail_number' => 'Sail number',
    'create.sail_area' => 'Sail area (m<sup>2</sup>)',
    'create.button' => 'Create new boat',

    // Boats show page
    'show.title' => ':boat.name - Boats',
    'show.description_empty' => 'This boat has no description',
    'show.boat_info' => 'Boat Information',
    'show.mmsi' => 'MMSI',
    'show.length' => 'Length overall',
    'show.breadth' => 'Breadth overall',
    'show.weight' => 'Weight',
    'show.sail_number' => 'Sail number',
    'show.sail_info' => 'Sail information',
    'show.sail_area' => 'Sail area',
    'show.klipperrace_info' => 'Klipperrace information',
    'show.klipperrace_rating' => 'Klipperrace rating',
    'show.track' => 'Track boat',
    'show.edit' => 'Edit boat',
    'show.delete' => 'Delete boat',

    'show.positions' => 'Boat Positions',

    'show.positions_map_title' => 'Boat positions',
    'show.positions_map_current' => 'Current boat position',
    'show.positions_map_latitude' => 'Latitude',
    'show.positions_map_longitude' => 'Longitude',
    'show.positions_map_time' => 'Time',
    'show.positions_map_edit' => 'Edit',
    'show.positions_map_delete' => 'Delete',

    'show.positions_empty' => 'This boat has no known positions',
    'show.positions_previous' => '&laquo; Previous day',
    'show.positions_today' => 'Today',
    'show.positions_next' => 'Next day &raquo;',
    'show.positions_latitude_field' => 'Latitude',
    'show.positions_longitude_field' => 'Longitude',
    'show.positions_add_button' => 'Add position',

    'show.boat_types' => 'Boat Types',
    'show.boat_types_remove_button' => 'Remove boat type',
    'show.boat_types_empty' => 'This boat has no assigned boat types',
    'show.boat_types_field' => 'Select a boat type...',
    'show.boat_types_add_button' => 'Add boat type',

    'show.users' => 'Boat Users',
    'show.users_role_crew' => 'CREW',
    'show.users_role_captain' => 'CAPTAIN',
    'show.users_make_crew_button' => 'Make crew',
    'show.users_make_captain_button' => 'Make captain',
    'show.users_remove_button' => 'Remove user',
    'show.users_empty' => 'This boat has no assigned users',
    'show.users_field' => 'Select a user...',
    'show.users_role_field_crew' => 'As crew',
    'show.users_role_field_captain' => 'As captain',
    'show.users_add_button' => 'Add user',

    // Boats track page
    'track.title' => 'Track - :boat.name - Boats',
    'track.breadcrumb' => 'Track',

    'track.map_title' => 'Boat positions',
    'track.map_current' => 'Current boat position',
    'track.map_latitude' => 'Latitude',
    'track.map_longitude' => 'Longitude',
    'track.map_time' => 'Time',
    'track.map_edit' => 'Edit',
    'track.map_delete' => 'Delete',

    'track.start_button' => 'Start tracking',
    'track.stop_button' => 'Stop tracking',
    'track.loading_text' => 'Loading...',
    'track.send_text_prefix' => 'Sending in',
    'track.send_text_suffix' => 'seconds...',
    'track.error' => 'Your browser doesn\'t support geolocation tracking!',

    // Boats edit page
    'edit.title' => 'Edit - :boat.name - Boats',
    'edit.breadcrumb' => 'Edit',
    'edit.header' => 'Edit boat',
    'edit.name' => 'Name',
    'edit.description' => 'Description',
    'edit.mmsi' => 'MMSI',
    'edit.length' => 'Length overall (m)',
    'edit.breadth' => 'Breadth overall (m)',
    'edit.weight' => 'Weight (kg)',
    'edit.sail_number' => 'Sail number',
    'edit.sail_area' => 'Sail area (m<sup>2</sup>)',
    'edit.button' => 'Edit boat',

    // ### Boat positions pages ###

    // Boat positions index page
    'positions.index.breadcrumb' => 'Positions',

    // Boat positions show page
    'positions.show.breadcrumb' => 'Boat Position',

    // Boat positions edit page
    'positions.edit.title' => 'Edit - :boat_position.name - Positions - :boat.name - Boats',
    'positions.edit.breadcrumb' => 'Edit',
    'positions.edit.header' => 'Edit boat position',
    'positions.edit.latitude' => 'Latitude',
    'positions.edit.longitude' => 'Longitude',
    'positions.edit.created_at_date' => 'Date',
    'positions.edit.created_at_time' => 'Time',
    'positions.edit.button' => 'Edit boat position'
];
