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

    // An event belongs to many classes.
    public function classes()
    {
        return $this->belongsToMany(EventClass::class);
    }

    // An event belongs to many finishes.
    public function finishes()
    {
        return $this->hasMany(Finish::class);
    }

    // Search by a query.
    public function search($query) {
        return Event::all()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('start', 'LIKE', '%' . $query . '%')
            ->orWhere('end', 'LIKE', '%' . $query . '%');
    }
}
