<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\Request;

class AdminApiKeysController extends Controller
{
    // Admin API keys index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $apiKeys = ApiKey::search($query)->get();
        } else {
            $apiKeys = ApiKey::all();
        }
        $apiKeys = $apiKeys->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin API keys index view
        return view('admin.api_keys.index', ['apiKeys' => $apiKeys]);
    }

    // Admin API keys store route
    public function store(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'level' => 'required|integer|digits_between:' . ApiKey::LEVEL_REQUIRE_AUTH . ',' . ApiKey::LEVEL_NO_AUTH
        ]);

        // Create API key
        $apiKey = ApiKey::create([
            'name' => $fields['name'],
            'key' => ApiKey::generateKey(),
            'level' => $fields['level']
        ]);

        // Go to the new admin API key page
        return redirect()->route('admin.api_keys.show', $apiKey);
    }

    // Admin API keys show route
    public function show(ApiKey $apiKey)
    {
        return view('admin.api_keys.show', ['apiKey' => $apiKey]);
    }

    // Admin API keys edit route
    public function edit(ApiKey $apiKey)
    {
        return view('admin.api_keys.edit', ['apiKey' => $apiKey]);
    }

    // Admin API keys update route
    public function update(Request $request, ApiKey $apiKey)
    {
        // Validate input
        $fields = $request->validate([
            'name' => 'required|min:2|max:48',
            'level' => 'required|integer|digits_between:' . ApiKey::LEVEL_REQUIRE_AUTH . ',' . ApiKey::LEVEL_NO_AUTH
        ]);

        // Update API key
        $apiKey->update([
            'name' => $fields['name'],
            'level' => $fields['level']
        ]);

        // Go to the admin API key page
        return redirect()->route('admin.api_keys.show', $apiKey);
    }

    // Admin API keys delete route
    public function delete(ApiKey $apiKey)
    {
        // Delete API key
        $apiKey->delete();

        // Go to the API keys index page
        return redirect()->route('admin.api_keys.index');
    }
}
