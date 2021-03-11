<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buoy extends Model {
    protected $fillable = [
        'name',
        'description'
    ];

    // Search by a query
    public static function search($query) {
        return static::where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('description', 'LIKE', '%' . $query . '%');
    }
}
