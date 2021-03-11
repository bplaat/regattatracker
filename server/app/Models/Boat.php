<?php

namespace App\Models;

use App\Models\User;
use App\Models\BoatType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Boat extends Model {
    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    // A boat belongs to a user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // A boat has many boat types
    public function boatTypes() {
        return $this->belongsToMany(BoatType::class);
    }

    // Search by a query
    public static function search($query) {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }

    // Search collection by a query
    public static function searchCollection($collection, $query) {
        return $collection->filter(function ($boat) use ($query) {
            return Str::contains(strtolower($boat->name), strtolower($query)) ||
                Str::contains(strtolower($boat->description), strtolower($query));
        });
    }

    // Delete boat and all its belongings
    public function completeDelete() {
        // Delete boat boat type connections
        $boatBoatTypes = BoatBoatType::where('boat_id', $this->id)->get();
        foreach ($boatBoatTypes as $boatBoatType) {
            $boatBoatType->delete();
        }

        // Delete boat
        $this->delete();
    }
}
