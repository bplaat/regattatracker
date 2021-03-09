<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Boat;

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

    // A user has many boats
    public function boats() {
        return $this->hasMany(Boat::class);
    }

    // Delete user and all its belongings
    public function completeDelete() {
        // Delete user boats
        foreach ($this->boats as $boat) {
            $boat->delete();
        }

        // Delete user
        $this->delete();
    }
}
