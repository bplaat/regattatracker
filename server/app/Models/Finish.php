<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finish extends Model
{
    protected $fillable = [
        'event',
        'latitude_a',
        'longitude_a',
        'latitude_b',
        'longitude_b'
    ];
}
