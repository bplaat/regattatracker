<?php

namespace App\Models;

use App\Pivots\EventClassFleetBoatPivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Boat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'mmsi',
        'length',
        'breadth',
        'weight',
        'sail_number',
        'sail_area'
    ];

    // Generate a random boat image name
    public static function generateImageName($extension)
    {
        if ($extension == 'jpeg') $extension = 'jpg';
        return md5('boat_image@' . microtime(true)) . '.' . $extension;
    }

    // Get the Klipperrace rating of the boat
    public function getKlipperraceRatingAttribute()
    {
        return $this->length * $this->sail_area / sqrt($this->breadth * $this->weight);
    }

    // A boat has many positions
    public function positions()
    {
        return $this->hasMany(BoatPosition::class)->orderByDesc('created_at');
    }

    // Get boat positions by day
    public function positionsByDay($time)
    {
        // When time is in future return nothing
        if ($time > time()) {
            return collect();
        }

        // Calculate start of the day timestamp
        $day = $time - ($time % (24 * 60 * 60));

        // Get all the positions of today
        $todayPositions = $this->positions()
            ->where('created_at', '>=', date('Y-m-d', $day))
            ->where('created_at', '<', date('Y-m-d', $day + 24 * 60 * 60))
            ->get();

        // Get all the positions of before this day to calculate latest position
        $oldPositions = $this->positions()
            ->where('created_at', '<', date('Y-m-d', $day));
        if ($oldPositions->count() > 0) {
            // Add latest position first of today positions
            $oldPosition = $oldPositions->first();
            if ($time >= $oldPosition->created_at->getTimestamp()) {
                $todayPositions->push($oldPosition);
            }
        }

        return $todayPositions;
    }

    // A boat belongs to many boat types
    public function boatTypes()
    {
        return $this->belongsToMany(BoatType::class)->withTimestamps();
    }

    // A boat belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }

    // A boat has many guests
    public function guests()
    {
        return $this->hasMany(BoatGuest::class);
    }

    // A boat belongs to many event class fleets
    public function eventClassFleets()
    {
        return $this->belongsToMany(EventClassFleet::class, 'event_class_fleet_boat')
            ->withPivot('started_at', 'finished_at')->withTimestamps()
            ->using(EventClassFleetBoatPivot::class);
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query)
    {
        return $collection->filter(function ($boat) use ($query) {
            return Str::contains(strtolower($boat->name), strtolower($query)) ||
                Str::contains(strtolower($boat->description), strtolower($query));
        });
    }
}
