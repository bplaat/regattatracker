[&laquo; Back to the README.md](../README.md)

# Models
Het RegattaTracker-project kent veel verschillende modellen, waarvan vele met elkaar verbonden zijn.

## Naamgeving & Relaties
Als de naam van een model-/databasetabel meervoudig is, is het een normale gegevenstabel, maar als het twee enkelvoudige namen zijn die samengevoegd zijn, is het een linktabel:
```
ApiKeys

Users
    has many PersonalAccessTokens

Boats
    has many BoatPositions
    belongs to many BoatTypes (BoatBoatType)
    belongs to many Users (BoatUser) (Permanent crew members)
    has many BoatGuests (Permanent crew members)

BoatTypes

Buoys
    has many BuoyPositions

Events
    has many EventFinishes
    has many EventClasses
        has many EventClassFleets
            belongs to many Boats (EventClassFleetBoat)
                belongs to many Users (EventClassFleetBoatUser) (Temporary crew members)
                has many EventClassFleetBoatGuests (Temporary crew members)
```
*Zoals u kan zien heeft het event model aardig wat belongs to relaties.*
