<?php

return [
    // Admin events index page
    'index.title' => 'Events - Admin',
    'index.breadcrumb' => 'Events',
    'index.header' => 'All events',
    'index.query_placeholder' => 'Search for events...',
    'index.search_button' => 'Search',
    'index.start' => 'Start date:',
    'index.start_empty' => 'No start date',
    'index.end' => 'End date:',
    'index.end_empty' => 'No end date',
    'index.connected' => 'Connected path:',
    'index.connected_true' => 'true',
    'index.connected_false' => 'false',
    'index.empty' => 'No events found',
    'index.create_button' => 'Create new event',

    // Admin events create page
    'create.title' => 'Create - Events - Admin',
    'create.breadcrumb' => 'Create',
    'create.header' => 'Create new event',
    'create.name' => 'Name',
    'create.start' => 'Start date',
    'create.end' => 'End date',
    'create.connected' => 'Connected path',
    'create.connected_true' => 'True',
    'create.connected_false' => 'False',
    'create.create_button' => 'Create new event',

    // Admin events show page
    'show.title' => ':event.name - Events - Admin',
    'show.date_info' => 'Date information',
    'show.start' => 'Start date:',
    'show.start_empty' => 'No start date',
    'show.end' => 'End date:',
    'show.end_empty' => 'No end date',
    'show.path_info' => 'Path information',
    'show.connected' => 'Connected path:',
    'show.connected_true' => 'true',
    'show.connected_false' => 'false',
    'show.edit_button' => 'Edit',
    'show.delete_button' => 'Delete',

    'show.map' => 'Event map',
    'show.map_add_point_button' => 'Add point',
    'show.map_add_finish_button' => 'Add finish',
    'show.map_connect_button' => 'Connect points path',
    'show.map_disconnect_button' => 'Disconnect points path',
    'show.map_path_length' => 'Path length:',
    'show.map_path_length_message' => 'Path must contain at least two points to calculate length!',
    'show.map_latitude' => 'Latitude',
    'show.map_longitude' => 'Longitude',
    'show.map_delete_button' => 'Delete',

    'show.finishes' => 'Finishes',
    'show.finishes_name' => 'Finish #:finish.id',
    'show.finishes_point_a' => 'Point A:',
    'show.finishes_point_b' => 'Point B:',
    'show.finishes_edit_button' => 'Edit',
    'show.finishes_delete_button' => 'Delete',
    'show.finishes_empty' => 'No finishes found',
    'show.finishes_create_button' => 'Create a new finish',

    'show.classes' => 'Classes',
    'show.classes_edit_button' => 'Edit',
    'show.classes_delete_button' => 'Delete',
    'show.classes_empty' => 'No classes found',
    'show.classes_create_button' => 'Create new class',

    'show.classes_fleets' => 'Fleets',
    'show.classes_fleets_edit_button' => 'Edit',
    'show.classes_fleets_delete_button' => 'Delete',
    'show.classes_fleets_empty' => 'No fleets found',
    'show.classes_fleets_create_button' => 'Create new fleet',

    'show.classes_fleets_crews' => 'Crew',
    'show.classes_fleets_crews_edit_button' => 'Edit',
    'show.classes_fleets_crews_delete_button' => 'Delete',
    'show.classes_fleets_crews_show_button' => 'Show Crew',
    'show.classes_fleets_crews_empty' => 'No crews found',
    'show.classes_fleets_crews_create_button' => 'Add new crew member',

    // Admin events edit page
    'edit.title' => 'Edit - :event.name - Events - Admin',
    'edit.breadcrumb' => 'Edit',
    'edit.header' => 'Edit event',
    'edit.name' => 'Name',
    'edit.start' => 'Start date',
    'edit.end' => 'End date',
    'edit.edit_button' => 'Edit event',

    // ### Event finishes pages ###

    // Event finishes index page
    'finishes.index.breadcrumb' => 'Finishes',

    // Event finishes show page
    'finishes.show.breadcrumb' => 'Finish #:event_finish.id',

    // Event finishes create page
    'finishes.create.title' => 'Create - Finishes - :event.name - Events - Admin',
    'finishes.create.breadcrumb' => 'Create',
    'finishes.create.header' => 'Create event finish',
    'finishes.create.latitude_a' => 'Latitude A',
    'finishes.create.longitude_a' => 'Longitude A',
    'finishes.create.latitude_b' => 'Latitude B',
    'finishes.create.longitude_b' => 'Longitude B',
    'finishes.create.create_button' => 'Create event finish',

    // Event finishes edit page
    'finishes.edit.title' => 'Edit - Finish #:event_finish.id - Finishes - :event.name - Events - Admin',
    'finishes.edit.breadcrumb' => 'Edit',
    'finishes.edit.header' => 'Edit event finish',
    'finishes.edit.latitude_a' => 'Latitude A',
    'finishes.edit.longitude_a' => 'Longitude A',
    'finishes.edit.latitude_b' => 'Latitude B',
    'finishes.edit.longitude_b' => 'Longitude B',
    'finishes.edit.edit_button' => 'Edit event finish',

    // ### Event classes pages ###

    // Event classes index page
    'classes.index.breadcrumb' => 'Classes',

    // Event classes create page
    'classes.create.title' => 'Create - Classes - :event.name - Events - Admin',
    'classes.create.breadcrumb' => 'Create',
    'classes.create.header' => 'Create class',
    'classes.create.flag' => 'Flag',
    'classes.create.flag.none' => 'None',
    'classes.create.name' => 'Name',
    'classes.create.create_button' => 'Create class',

    // Event classes edit page
    'classes.edit.title' => 'Edit - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.edit.breadcrumb' => 'Edit',
    'classes.edit.header' => 'Edit class',
    'classes.edit.flag' => 'Flag',
    'classes.edit.flag.none' => 'None',
    'classes.edit.name' => 'Name',
    'classes.edit.edit_button' => 'Edit class',

    // ### Event class fleets pages ###

    // Event class fleets index page
    'classes.fleets.index.breadcrumb' => 'Fleets',

    // Event class fleets create page
    'classes.fleets.create.title' => 'Create - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.create.breadcrumb' => 'Create',
    'classes.fleets.create.header' => 'Create fleet',
    'classes.fleets.create.name' => 'Name',
    'classes.fleets.create.create_button' => 'Create fleet',

    // Event class fleets edit page
    'classes.fleets.edit.title' => 'Edit - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.edit.breadcrumb' => 'Edit',
    'classes.fleets.edit.header' => 'Edit fleet',
    'classes.fleets.edit.name' => 'Name',
    'classes.fleets.edit.edit_button' => 'Edit fleet',

    //### Event class fleet crews pages ###
    // Event class fleet crews index page
    'classes.fleets.crews.index.breadcrumb' => 'Crews',

    // Event class fleet crews create page
    'classes.fleets.crews.create.title' => 'Create - Crews - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.crews.create.breadcrumb' => 'Create',
    'classes.fleets.crews.create.header' => 'Create Crew',
    'classes.fleets.crews.create.name' => 'Name',
    'classes.fleets.crews.create.create_button' => 'Create Crew',

    //Event class fleet crews show page
    'classes.fleets.crews.show.title' => 'Show - Crews - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.crews.show.breadcrumb' => 'Show',
    'classes.fleets.crews.show.header' => 'Show Crew',
    'classes.fleets.crews.show.name' => 'Name',
    'classes.fleets.crews.show.show_button' => 'Show Crew',

    // Event class fleets edit page
    'classes.fleets.crews.edit.title' => 'Edit - :event_class_crew.name - Crews - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.crews.edit.breadcrumb' => 'Edit',
    'classes.fleets.crews.edit.header' => 'Edit crew member',
    'classes.fleets.crews.edit.name' => 'Name',
    'classes.fleets.crews.edit.edit_button' => 'Edit crew member'

];
