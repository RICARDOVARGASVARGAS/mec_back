<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'name' => $this->faker->word(),
            'ticket' => $this->faker->word(),
            'price_buy' => $this->faker->randomFloat(2, 10, 1000),
            'price_sell' => $this->faker->randomFloat(2, 10, 1000),
            'company_id' => Company::all()->random()->id,
        ];
    }
}
