<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        $client = Client::all()->random();
        return [
            'number' => $this->faker->randomNumber(),
            'km' => $this->faker->randomNumber(),
            'entry_date' => $this->faker->date(),
            'exit_date' => $this->faker->date(),
            'payment_date' => $this->faker->date(),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'status' => $this->faker->randomElement(['pending', 'done', 'cancelled', 'debt']),
            'client_id' => $client->id,
            'car_id' => Car::whereRelation('client', 'company_id', '=', $client->company_id)->inRandomOrder()->first()->id,
            'company_id' => $client->company_id
        ];
    }
}
