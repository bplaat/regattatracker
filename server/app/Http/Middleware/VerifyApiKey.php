<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VerifyApiKey
{
    public function handle($request, $next, $guard = null)
    {
        $validation = Validator::make($request->all(), [
            'api_key' => 'required|exists:api_keys,key'
        ]);
        if ($validation->fails()) {
            return response(['errors' => $validation->errors()], 400);
        }

        return $next($request);
    }
}
