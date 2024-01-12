<?php

namespace Database\Factories;

use App\Models\Box;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $sale = Sale::all()->random();
        return [
            'detail' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'date_payment' => $this->faker->date(),
            'sale_id' => $sale->id,
            'box_id' => Box::where('company_id', $sale->company_id)->inRandomOrder()->first()->id
        ];
    }
}
