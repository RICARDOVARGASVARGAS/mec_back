<?php

namespace Database\Factories;

use App\Models\Box;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount' => $this->faker->numberBetween(-10000, 10000),
            'detail' => $this->faker->sentence(),
            'date_movement' => $this->faker->date(),
            'client_id' => Client::all()->random()->id,
            'box_id' => Box::all()->random()->id,
        ];
    }
}
