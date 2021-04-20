<?php

namespace Database\Factories;

use App\Models\CompetitionClass;
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
            'competition_class_id' => $this->faker->randomElement(CompetitionClass::all()->pluck('id')->toArray())
        ];
    }
}
