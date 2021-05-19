<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventFinish;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFinishFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventFinish::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => $this->faker->randomElement(Event::all()->pluck('id')->toArray()),
            'latitude_a' => $this->faker->latitude,
            'longitude_a' => $this->faker->longitude,
            'latitude_b' => $this->faker->latitude,
            'longitude_b' => $this->faker->longitude
        ];
    }
}
