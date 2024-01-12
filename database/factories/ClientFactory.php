<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'document' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'name' => $this->faker->name(),
            'surname' => $this->faker->firstNameFemale(),
            'last_name' => $this->faker->firstName(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'company_id' => Company::all()->random()->id,
        ];
    }
}
