<?php

return [
    // Boats index page
    'index.title' => 'Boats',
    'index.breadcrumb' => 'Boats',
    'index.header' => 'All your boats',
    'index.query_placeholder' => 'Search for boats...',
    'index.search_button' => 'Search',
    'index.role_crew' => 'CREW',
    'index.role_captain' => 'CAPTAIN',
    'index.empty' => 'There are no boats found',
    'index.create_button' => 'Create new boat',

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
    'create.create_button' => 'Create new boat',

    // Boats show page
    'show.title' => ':boat.name - Boats',
    'show.description_empty' => 'This boat has no description',
    'show.boat_info' => 'Boat Information',
    'show.mmsi' => 'MMSI:',
    'show.length' => 'Length overall:',
    'show.breadth' => 'Breadth overall:',
    'show.weight' => 'Weight:',
    'show.sail_info' => 'Sail information',
    'show.sail_number' => 'Sail number:',
    'show.sail_area' => 'Sail area:',
    'show.handicap_info' => 'Handicap information',
    'show.klipperrace_rating' => 'Klipperrace rating:',
    'show.track_button' => 'Track boat',
    'show.edit_button' => 'Edit boat',
    'show.delete_button' => 'Delete boat',

    'show.positions' => 'Boat Positions',

    'show.positions_map_name' => 'Boat Position #:item_position.id',
    'show.positions_map_current' => 'Current boat position',
    'show.positions_map_latitude' => 'Latitude',
    'show.positions_map_longitude' => 'Longitude',
    'show.positions_map_time' => 'Time',
    'show.positions_map_edit_button' => 'Edit',
    'show.positions_map_delete_button' => 'Delete',

    'show.positions_empty' => 'This boat has no known positions',
    'show.positions_previous_button' => '&laquo; Previous day',
    'show.positions_today_button' => 'Today',
    'show.positions_next_button' => 'Next day &raquo;',
    'show.positions_latitude_placeholder' => 'Latitude',
    'show.positions_longitude_placeholder' => 'Longitude',
    'show.positions_add_button' => 'Add position',

    'show.boat_types' => 'Boat Types',
    'show.boat_types_remove_button' => 'Remove boat type',
    'show.boat_types_empty' => 'This boat has no assigned boat types',
    'show.boat_types_placeholder' => 'Select a boat type...',
    'show.boat_types_add_button' => 'Add boat type',

    'show.users' => 'Boat Users',
    'show.users_role_crew' => 'CREW',
    'show.users_role_captain' => 'CAPTAIN',
    'show.users_make_crew_button' => 'Make crew',
    'show.users_make_captain_button' => 'Make captain',
    'show.users_remove_button' => 'Remove user',
    'show.users_empty' => 'This boat has no assigned users',
    'show.users_placeholder' => 'Select a user...',
    'show.users_role_crew_placeholder' => 'As crew',
    'show.users_role_captain_placeholder' => 'As captain',
    'show.users_add_button' => 'Add user',

    'show.guests' => 'Boat Guests',
    'show.guests_role_crew' => 'CREW',
    'show.guest_edit_button' => 'Edit guest',
    'show.guests_remove_button' => 'Remove guest',
    'show.guests_empty' => 'This boat has no guests',
    'show.guests_add_button' => 'Add guest',
    'show.guests_create_button' => 'Create guest',

    // Boats track page
    'track.title' => 'Track - :boat.name - Boats',
    'track.breadcrumb' => 'Track',

    'track.map_name' => 'Boat Position #:item_position.id',
    'track.map_current' => 'Current boat position',
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
    'edit.edit_button' => 'Edit boat',

    // ### Boat positions pages ###

    // Boat positions index page
    'positions.index.breadcrumb' => 'Positions',

    // Boat positions show page
    'positions.show.breadcrumb' => 'Boat Position #:boat_position.id',

    // Boat positions edit page
    'positions.edit.title' => 'Edit - Boat Position #:boat_position.id - Positions - :boat.name - Boats',
    'positions.edit.breadcrumb' => 'Edit',
    'positions.edit.header' => 'Edit boat position',
    'positions.edit.latitude' => 'Latitude',
    'positions.edit.longitude' => 'Longitude',
    'positions.edit.created_at_date' => 'Date',
    'positions.edit.created_at_time' => 'Time',
    'positions.edit.edit_button' => 'Edit boat position',

    // ### Boat guests pages ###

    // Boat guest create page
    'guests.create.title' => 'Create - Guests - :boat.name - Boats',
    'guests.create.breadcrumb' => 'Create',
    'guests.create.header' => 'Create new guest',
    'guests.create.firstname' => 'First name',
    'guests.create.insertion' => 'Insertion',
    'guests.create.lastname' => 'Last name',
    'guests.create.gender' => 'Gender',
    'guests.create.gender_male' => 'Male',
    'guests.create.gender_female' => 'Female',
    'guests.create.gender_other' => 'Other',
    'guests.create.birthday' => 'Birthday',
    'guests.create.email' => 'Email address',
    'guests.create.phone' => 'Phone',
    'guests.create.address' => 'Address (street with house number)',
    'guests.create.postcode' => 'Postcode',
    'guests.create.city' => 'City',
    'guests.create.country' => 'Country',
    'guests.create.create_button' => 'Create new guest',

    // Boat guest edit page
    'guests.edit.title' => 'Edit - boat_guest.name - Guests - :boat.name - Boats',
    'guests.edit.breadcrumb' => 'Edit',
    'guests.edit.header' => 'Edit guest',
    'guests.edit.firstname' => 'First name',
    'guests.edit.insertion' => 'Insertion',
    'guests.edit.lastname' => 'Last name',
    'guests.edit.gender' => 'Gender',
    'guests.edit.gender_male' => 'Male',
    'guests.edit.gender_female' => 'Female',
    'guests.edit.gender_other' => 'Other',
    'guests.edit.birthday' => 'Birthday',
    'guests.edit.email' => 'Email address',
    'guests.edit.phone' => 'Phone',
    'guests.edit.address' => 'Address (street with house number)',
    'guests.edit.postcode' => 'Postcode',
    'guests.edit.city' => 'City',
    'guests.edit.country' => 'Country',
    'guests.edit.create_button' => 'Edit guest'
];
