<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoatPosition extends Model
{
    protected $fillable = [
        'boat_id',
        'latitude',
        'longitude',
        'created_at'
    ];

    // A boat position belongs to an boat
    public function boat() {
        return $this->belongsTo(Boat::class);
    }
}
