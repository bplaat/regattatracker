<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'firstname' => 'Giel',
            'insertion' => 'van',
            'lastname' => 'Gielens',
            'gender' => 1,
            'birthday' => date('Y-m-d',1978-02-20),
            'email' => 'giel.gielens@example.com',
            'phone' => '+1-352-989-1711',
            'address' => '6986 Kendrick Inlet',
            'postcode' => '30526',
            'city' => 'Hageneshaven',
            'country' => 'Botswana',
            'password' => Hash::make('gielgielens'),
            'role' => 1
        ]);

        DB::table('boats')->insert([
//            'id' => Str::random(10),
            'name' => 'giel',
            'description' => 'test boat',
            'mmsi' => 123456789,
            'length' => 123,
            'breadth' => 456,
            'weight' => 654,
            'sail_number' => 123456,
            'sail_area' => 321,
        ]);

        DB::table('boat_positions')->insert([
//            'id' => Str::random(10),
            'boat_id' => 1,
            'latitude' => 50,
            'longitude' => 60,
        ]);

        DB::table('buoys')->insert([
//            'id' => Str::random(10),
            'name' => 'testBuoy',
            'description' => 'test buoy',
        ]);

        DB::table('buoy_positions')->insert([
//            'id' => Str::random(10),
            'buoy_id' => 1,
            'latitude' => 10,
            'longitude' => 20,
        ]);

        // Create API key for the website
        ApiKey::create([
            'name' => 'APITESTS',
            'key' => '25977eb7e1be7986a17be02b7443eb15',
            'level' => 1
        ]);
    }
}
