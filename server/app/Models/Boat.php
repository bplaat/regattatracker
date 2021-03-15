<?php

namespace App\Models;

use App\Models\User;
use App\Models\BoatType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Boat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'mmsi',
        'length',
        'breadth',
        'weight',
        'sail_number',
        'sail_area'
    ];

    // Get the KlipperRace rating of the boat
    public function klipperraceRating()
    {
        return $this->length * $this->sail_area / sqrt($this->breadth * $this->weight);
    }

    // A boat has many boat types
    public function boatTypes()
    {
        return $this->belongsToMany(BoatType::class);
    }

    // A boat belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
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
