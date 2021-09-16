<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoatGuest extends Model
{
    protected $fillable = [
        'boat_id',
        'firstname',
        'insertion',
        'lastname',
        'gender',
        'birthday',
        'email',
        'phone',
        'address',
        'postcode',
        'city',
        'country'
    ];

    protected $casts = [
        'birthday' => 'datetime'
    ];

    // Get user full name (firstname insertion lastname)
    public function getNameAttribute()
    {
        if ($this->insertion != null) {
            return $this->firstname . ' ' . $this->insertion . ' ' . $this->lastname;
        } else {
            return $this->firstname . ' ' . $this->lastname;
        }
    }

    // A boat guest belongs to a boat
    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }
}
