<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiTest extends TestCase
{

    var $apiKey = '25977eb7e1be7986a17be02b7443eb15';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_auth()
    {

        $email = 'giel.gielens@example.com';
        $password = 'gielgielens';

        $response = $this->get("/api/auth/login?api_key={$this->apiKey}&email={$email}&password={$password}");
        $response->dump();
        $response
            ->assertStatus(200)
            ->assertJson(['token' => true]);
    }




    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_boats()
    {

        $response = $this->get("/api/boats?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.id',1)
            ->assertJsonPath('data.0.name','giel')
            ->assertJsonPath('data.0.description','test boat')
            ->assertJsonPath('data.0.mmsi','123456789')
            ->assertJsonPath('data.0.length','123.00')
            ->assertJsonPath('data.0.breadth','456.00')
            ->assertJsonPath('data.0.weight','654.000')
            ->assertJsonPath('data.0.sail_number',123456)
            ->assertJsonPath('data.0.sail_area','321.00');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_boat()
    {

        $response = $this->get("/api/boats/1?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('id',1)
            ->assertJsonPath('name','giel')
            ->assertJsonPath('description','test boat')
            ->assertJsonPath('mmsi','123456789')
            ->assertJsonPath('length','123.00')
            ->assertJsonPath('breadth','456.00')
            ->assertJsonPath('weight','654.000')
            ->assertJsonPath('sail_number',123456)
            ->assertJsonPath('sail_area','321.00');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_boatPos()
    {
        $response = $this->get("/api/boats/1/positions?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.id',1)
            ->assertJsonPath('data.0.boat_id',1)
            ->assertJsonPath('data.0.latitude','50.00000000')
            ->assertJsonPath('data.0.longitude','60.00000000');


    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_buoys()
    {
        $response = $this->get("/api/buoys?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.id',1)
            ->assertJsonPath('data.0.name','testBuoy')
            ->assertJsonPath('data.0.description','test buoy');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_buoy()
    {
        $response = $this->get("/api/buoys/1?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('id',1)
            ->assertJsonPath('name','testBuoy')
            ->assertJsonPath('description','test buoy');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_buoyPos()
    {
        $response = $this->get("/api/buoys/1/positions?api_key={$this->apiKey}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.id',1)
            ->assertJsonPath('data.0.buoy_id',1)
            ->assertJsonPath('data.0.latitude','10.00000000')
            ->assertJsonPath('data.0.longitude','20.00000000');


    }
}
