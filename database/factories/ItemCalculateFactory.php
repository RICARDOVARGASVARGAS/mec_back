<?php

namespace Database\Factories;

use App\Models\Calculate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemCalculate>
 */
class ItemCalculateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount_item' => 4,
            'description_item' => $this->faker->word(),
            'brand_item' =>  $this->faker->word(),
            'price_item' => 5.25,
            'calculate_id' => Calculate::all()->random()->id
        ];
    }
}
