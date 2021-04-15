<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buoy extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    // A buoy has many positions
    public function positions()
    {
        return $this->hasMany(BuoyPosition::class);
    }

    // Get buoy positions by day
    public function positionsByDay($time)
    {
        if ($time > time()) {
            return collect();
        }

        $day = $time - ($time % (24 * 60 * 60));

        $todayPositions = $this->positions()
            ->where('created_at', '>=', date('Y-m-d', $day))
            ->where('created_at', '<', date('Y-m-d', $day + 24 * 60 * 60))
            ->get();

        $oldPositions = $this->positions()
            ->where('created_at', '<', date('Y-m-d', $day - 1))
            ->orderByDesc('created_at');

        if ($oldPositions->count() > 0) {
            $oldPosition = $oldPositions->first();
            if ($time >= $oldPosition->created_at->getTimestamp()) {
                $todayPositions->prepend($oldPosition);
            }
        }

        return $todayPositions;
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }
}
