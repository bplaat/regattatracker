<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'event_id'
    ];
}
