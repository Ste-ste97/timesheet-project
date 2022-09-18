<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => $this->faker->name(),
            'greek_name' => $this->faker->name()
        ];
    }
}
