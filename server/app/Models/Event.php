<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end',
        'connected',
        'path'
    ];

    protected $casts = [
        'connected' => 'boolean'
    ];

    // An event has many finishes
    public function finishes()
    {
        return $this->hasMany(EventFinish::class);
    }

    // An event has many classes
    public function classes()
    {
        return $this->hasMany(EventClass::class);
    }

    // Search by a query.
    public function search($query) {
        return Event::all()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('start', 'LIKE', '%' . $query . '%')
            ->orWhere('end', 'LIKE', '%' . $query . '%');
    }
}
