<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'mobile_phone' => $this->faker->phoneNumber(),
            'landline_phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'fax' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'postal_code' => $this->faker->postcode(),
        ];
    }
}
