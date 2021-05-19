<?php

namespace Database\Factories;

use App\Models\EventClass;
use App\Models\EventClassFleet;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventClassFleetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventClassFleet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_class_id' => $this->faker->randomElement(EventClass::all()->pluck('id')->toArray()),
            'name' => $this->faker->name
        ];
    }
}
