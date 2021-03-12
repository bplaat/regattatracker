<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class Admin {
    public function handle($request, $next, $guard = null) {
        if (!Auth::check() || Auth::user()->role != User::ROLE_ADMIN) {
            abort(403);
        }

        return $next($request);
    }
}
