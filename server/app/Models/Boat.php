<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BoatType;

class Boat extends Model {
    protected $fillable = [
        'user_id',
        'name',
        'description'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function boatTypes() {
        return $this->belongsToMany(BoatType::class);
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
