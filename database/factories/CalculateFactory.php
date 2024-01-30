<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calculate>
 */
class CalculateFactory extends Factory
{
    public function definition(): array
    {
        $client = Client::all()->random();
        return [
            'number' => $this->faker->randomNumber(),
            'client_id' => $client->id,
            'car_id' => Car::whereRelation('client', 'company_id', '=', $client->company_id)->inRandomOrder()->first()->id,
            'company_id' => $client->company_id
        ];
    }
}
