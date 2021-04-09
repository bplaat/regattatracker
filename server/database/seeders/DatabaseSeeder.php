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

        // Create API key for the website
        ApiKey::create([
            'name' => 'Website',
            'key' => ApiKey::generateKey(),
            'level' => ApiKey::LEVEL_REQUIRE_AUTH
        ]);
    }
}
