<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Boat;

class BoatType extends Model {
    protected $fillable = [
        'name',
        'description'
    ];

    public function boats() {
        return $this->belongsToMany(Boat::class);
    }
}
