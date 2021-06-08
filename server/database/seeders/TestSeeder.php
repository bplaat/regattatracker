<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\Boat;
use App\Models\Buoy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create test user
        User::create([
            'firstname' => 'Giel',
            'insertion' => 'van',
            'lastname' => 'Gielens',
            'gender' => 1,
            'birthday' => '1978-02-20',
            'email' => 'giel.gielens@example.com',
            'phone' => '+1-352-989-1711',
            'address' => '6986 Kendrick Inlet',
            'postcode' => '30526',
            'city' => 'Hageneshaven',
            'country' => 'Botswana',
            'password' => Hash::make('gielgielens'),
            'role' => 1
        ]);

        // Create test boat
        $boat = Boat::create([
            'name' => 'giel',
            'description' => 'test boat',
            'mmsi' => 123456789,
            'length' => 123,
            'breadth' => 456,
            'weight' => 654,
            'sail_number' => '123456',
            'sail_area' => 321
        ]);
        $boat->positions()->create([
            'latitude' => 50,
            'longitude' => 60
        ]);

        // Create test buoy
        $buoy = Buoy::create([
            'name' => 'testBuoy',
            'description' => 'test buoy'
        ]);
        $buoy->positions()->create([
            'latitude' => 10,
            'longitude' => 20
        ]);

        // Create API key for the tests
        ApiKey::create([
            'name' => 'ApiTests',
            'key' => '25977eb7e1be7986a17be02b7443eb15',
            'level' => ApiKey::LEVEL_NO_AUTH
        ]);
    }
}
