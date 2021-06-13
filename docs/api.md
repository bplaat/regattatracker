[&laquo; Back to the README.md](../README.md)

# API Documentation
The RettaTracker website has an REST API which you can use to read and alter information on the RegattaTracker website:

## Routes
This is a list off al current API routes and there names:
```
GET /api : api.home

GET /api/boats : api.boats.index
GET /api/boats/{boat} : api.boats.show
GET /api/boats/{boat}/positions : boats.positions.index
POST /api/boats/{boat}/positions : api.boats.positions.store
GET /api/boats/{boat}/positions/{boatPosition} : api.boats.positions.show
POST /api/boats/{boat}/positions/{boatPosition} : api.boats.positions.update
GET /api/boats/{boat}/positions/{boatPosition}/delete : api.boats.positions.delete
GET /api/boats/{boat}/boat_types : api.boats.boat_types.index
GET /api/boats/{boat}/boat_types/{boatType} : api.boats.boat_types.show
GET /api/boats/{boat}/users : api.boats.users.index
GET /api/boats/{boat}/users/{user} : api.boats.users.show

GET /api/buoys : api.buoys.index
GET /api/buoys/{buoy} : api.buoys.show
GET /api/buoys/{buoy}/positions : api.buoys.positions.index
POST /api/buoys/{buoy}/positions : api.buoys.positions.store
GET /api/buoys/{buoy}/positions/{buoyPosition} : api.buoys.positions.show
POST /api/buoys/{buoy}/positions/{buoyPosition} : api.buoys.positions.update
GET /api/buoys/{buoy}/positions/{buoyPosition}/delete : api.buoys.positions.delete

GET /api/events : api.events.index
POST /api/events : api.events.store
GET /api/events/{event} : api.events.show
POST /api/events/{event} : api.events.update
GET /api/events/{event}/delete : api.events.delete

GET /api/events/{event}/finishes : api.events.finishes.index
POST /api/events/{event}/finishes : api.events.finishes.store
GET /api/events/{event}/finishes/{eventFinish} : api.events.finishes.show
POST /api/events/{event}/finishes/{eventFinish} : api.events.finishes.update
GET /api/events/{event}/finishes/{eventFinish}/delete : api.events.finishes.delete

GET /api/events/{event}/classes : api.events.classes.index
GET /api/events/{event}/classes/{eventClass} : api.events.classes.show

GET /api/events/{event}/classes/{eventClass}/fleets : api.events.classes.fleets.index
GET /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}
    : api.events.classes.fleets.show

GET /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats
    : api.events.classes.fleets.boats.index
POST /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats
    : api.events.classes.fleets.boats.store
GET /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}
    : api.events.classes.fleets.boats.show
POST /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}
    : api.events.classes.fleets.boats.update
GET /api/events/{event}/classes/{eventClass}/fleets/{eventClassFleet}/boats/{boat}/delete
    : api.events.classes.fleets.boats.delete

GET /api/auth/logout : api.auth.logout

ANY /api/auth/login : api.auth.login
ANY /api/auth/register : api.auth.register
```

## Buoy position store
You can send a POST message to `/api/buoys/{buoy_id}/positions` to update the position of that buoy, you will need to create an API Key in the Admin panel to send this HTTP request, here is a simple Python example:
```python
import requests

buoy_id = 1
requests.post('https://test.regattatracker.nl/api/buoys/' + str(buoy_id) + '/positions', data = {
    'api_key': 'b83f630c4765a12193806f57b148c385',
    'latitude': 52.0,
    'longitude': 4.7
})
```
