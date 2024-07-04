<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'uuid' => (string)Str::uuid(),
            'name' => json_encode([
                'title' => $this->faker->title,
                'first' => $this->faker->firstName,
                'last'  => $this->faker->lastName,
            ]),
            'gender'   => $this->faker->randomElement(['male', 'female']),
           'location' => json_encode([
                'city'    => $this->faker->city,
                'state'   => $this->faker->state,
                'country' => $this->faker->country,
            ]),
            'age'      => $this->faker->numberBetween(18, 65),
        ];
    }

}
