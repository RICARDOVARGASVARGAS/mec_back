<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Color;
use App\Models\Example;
use App\Models\Year;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'plate' => $this->faker->numerify('###-###'),
            'engine' => $this->faker->word(),
            'chassis' => $this->faker->word(),
            'client_id' => Client::all()->random()->id,
            'example_id' => Example::all()->random()->id,
            'color_id' => Color::all()->random()->id,
            'brand_id' => Brand::all()->random()->id,
            'year_id' => Year::all()->random()->id
        ];
    }
}
