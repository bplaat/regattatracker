<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create 100 random users
        User::factory(100)->create();

        // Create default API Key
        ApiKey::create([
            'name' => 'Default API Key',
            'key' => ApiKey::generateKey()
        ]);
    }
}
