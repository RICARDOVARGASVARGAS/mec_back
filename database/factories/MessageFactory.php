<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    public function definition(): array
    {
        // $type = $this->faker->randomElement(['text', 'image']);
        $user =  User::inRandomOrder()->first();

        return [
            'type' => 'text',
            // 'content' => $type == 'text' ? $this->faker->sentence : $this->faker->imageUrl(),
            'content' => $this->faker->sentence,
            'user_id' => $user->id,
            'sale_id' => Sale::where('company_id', $user->company_id)->inRandomOrder()->first()->id
        ];
    }
}
