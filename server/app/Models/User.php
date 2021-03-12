<?php

namespace App\Models;

use App\Models\Boat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // A user can be normal or an admin
    const ROLE_NORMAL = 0;
    const ROLE_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Search by a query
    public static function search($query)
    {
        return static::where('firstname', 'LIKE', '%' . $query . '%')
            ->orWhere('lastname', 'LIKE', '%' . $query . '%')
            ->orWhere('email', 'LIKE', '%' . $query . '%');
    }

    // A boat belongs to many boats
    public function boats()
    {
        return $this->belongsToMany(Boat::class)->withPivot('role');
    }
}
