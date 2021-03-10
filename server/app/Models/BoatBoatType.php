<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatBoatType extends Model {
    protected $table = 'boat_boat_type';

    protected $fillable = [
        'boat_id',
        'boat_type_id'
    ];
}
