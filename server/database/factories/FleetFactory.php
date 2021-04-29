<?php

namespace Database\Factories;

use App\Models\EventClass;
use App\Models\Fleet;
use Illuminate\Database\Eloquent\Factories\Factory;

class FleetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Fleet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'event_class_id' => $this->faker->randomElement(EventClass::all()->pluck('id')->toArray())
        ];
    }
}
