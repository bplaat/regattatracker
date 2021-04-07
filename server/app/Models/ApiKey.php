<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $fillable = [
        'name',
        'key'
    ];

    // Generate a random key
    public static function generateKey() {
        return md5('api_key@' . microtime(true)); // Secure???
    }

    // Search by a query
    public static function search($query)
    {
        return static::where('name', 'LIKE', '%' . $query . '%');
    }
}
