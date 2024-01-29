<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoxFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->word(),
            'company_id' => Company::all()->random()->id,
        ];
    }
}
