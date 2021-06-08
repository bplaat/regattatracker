[&laquo; Back to the README.md](../README.md)

# Models
The RegattaTracker project has many different models, many of them are connected with each other.

## Relationships
If a model / database table name is plural it is a normal data table but if it is two singular names joined together then it is a link table:
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
