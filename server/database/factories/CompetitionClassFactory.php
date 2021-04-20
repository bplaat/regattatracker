<?php

namespace Database\Factories;

use App\Models\Competition;
use App\Models\CompetitionClass;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompetitionClassFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CompetitionClass::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'competition_id' => $this->faker->randomElement(Competition::all()->pluck('id')->toArray())
        ];
    }
}
