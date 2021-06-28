[&laquo; Back to the README.md](../README.md)

# API Documentatie
Did you mean: The Retta Tracker website has an REST API which you can use to read and alter information on the Regatta Tracker website

## Routes
Hier is een lijst met alle API routes die op dit moment aanwezig zijn in het RegattaTracker project:
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

*Hier onder staan nog een aantal voorbeelden van hoe je verschillende routes in de REST API kan aanroepen via een simpel Python script:*

## Buoy position store
U kunt een POST-bericht naar `/api/buoys/{buoy_id}/positions` sturen om de positie van die boei bij te werken, u moet een API-sleutel aanmaken in het admin gedeelte om dit bericht te verzenden, hier zijn enkele eenvoudige Python-voorbeelden om het bericht te verzenden:


**Met een account auth token:**
```python
import requests

buoy_id = 1
req = requests.post('https://test.regattatracker.nl/api/buoys/' + str(buoy_id) + '/positions', data = {
    'api_key': '7538dba4eecc68799e5c307f12251f76',
    'latitude': 52.0,
    'longitude': 4.7
})
print(req.text)
```

**Zonder account auth token:**
```python
import requests

buoy_id = 1
req = requests.post('https://test.regattatracker.nl/api/buoys/' + str(buoy_id) + '/positions',
    headers = { 'Authorization': 'Bearer 6|fmhbWnlndZ6BPhew8aLnUryh6tlFCr9RanCYAlZ5' },
    data = {
        'api_key': '7538dba4eecc68799e5c307f12251f76',
        'latitude': 52.0,
        'longitude': 4.725
    }
)
print(req.text)
```

**Alleen met standaard bibliotheek functies en met account auth token:**
```python
from urllib import request, parse

buoy_id = 1
data = parse.urlencode({
    'api_key': '7538dba4eecc68799e5c307f12251f76',
    'latitude': 52.0,
    'longitude': 4.71
}).encode()

req = request.Request('https://test.regattatracker.nl/api/buoys/' + str(buoy_id) + '/positions', data = data)
response = request.urlopen(req)
print(response.read().decode())
```
**Alleen met standaard bibliotheek functies en zonder account auth token:**
```python
from urllib import request, parse

buoy_id = 1
data = parse.urlencode({
    'api_key': '7538dba4eecc68799e5c307f12251f76',
    'latitude': 52.0,
    'longitude': 4.71
}).encode()

req = request.Request('https://test.regattatracker.nl/api/buoys/' + str(buoy_id) + '/positions', data = data)
req.add_header('Authorization', 'Bearer 6|fmhbWnlndZ6BPhew8aLnUryh6tlFCr9RanCYAlZ5')
response = request.urlopen(req)
print(response.read().decode())
```
