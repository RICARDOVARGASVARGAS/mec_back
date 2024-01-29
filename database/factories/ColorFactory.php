<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->colorName(),
            'hex' => $this->faker->hexColor(),
            'company_id' => Company::all()->random()->id
        ];
    }
}
