<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'insertion' => $this->faker->randomElement(['Van Der', 'Van', 'Uit', 'De', null]),
            'lastname' => $this->faker->lastName,
            'gender' => $this->faker->randomElement([0, 1, 2]),
            'birthday' => $this->faker->date(),
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'zipcode' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make($this->faker->password)
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
