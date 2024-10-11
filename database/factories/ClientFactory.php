<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition()
    {
        return [
            'name'           => $this->faker->company(),
            'is_private'     => false,
            'mobile_phone'   => $this->faker->phoneNumber(),
            'landline_phone' => $this->faker->phoneNumber(),
            'address'        => $this->faker->address(),
            'fax'            => $this->faker->phoneNumber(),
            'email'          => $this->faker->unique()->safeEmail(),
            'postal_code'    => $this->faker->postcode(),
        ];
    }

    public function withName($name)
    {
        return $this->state([
            'name' => $name,
        ]);
    }


}
