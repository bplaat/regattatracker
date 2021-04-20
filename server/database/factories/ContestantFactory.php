<?php

namespace Database\Factories;

use App\Models\Contestant;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContestantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contestant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fleet_id' => $this->faker->randomElement(Fleet::all()->pluck('id')->toArray()),
            'boat_id' => $this->faker->randomElement(Boat::all()->pluck('id')->toArray())
        ];
    }
}
