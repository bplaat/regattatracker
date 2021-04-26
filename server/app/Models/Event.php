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
      'end'
    ];

    // A event belongs to many classes.
    public function classes() {
        return $this->belongsToMany(EventClass::class);
    }

    // Search by a query.
    public function search($query) {
        return Event::all()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('start', 'LIKE', '%' . $query . '%')
            ->orWhere('end', 'LIKE', '%' . $query . '%');
    }
}
