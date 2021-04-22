<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'start',
      'end'
    ];

    // A competition belongs to many classes.
    public function classes() {
        return $this->belongsToMany(CompetitionClass::class);
    }

    // Competition start and end time for the forums.
    public function startTime() {
        return strtotime($this->getAttribute('start'));
    }

    public function endTime() {
        return strtotime($this->getAttribute('end'));
    }

    // Search by a query.
    public function search($query) {
        return Competition::all()->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('start', 'LIKE', '%' . $query . '%')
            ->orWhere('end', 'LIKE', '%' . $query . '%');
    }
}
