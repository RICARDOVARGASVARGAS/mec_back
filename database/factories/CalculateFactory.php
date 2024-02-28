<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Client;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calculate>
 */
class CalculateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => $this->faker->randomNumber(),
            'property_calculate' => 'property_calculate',
            'driver_calculate' => 'driver_calculate',
            'ruc_calculate' => 'ruc_calculate',
            'dni_calculate' => 'dni_calculate',
            'phone_calculate' => 'phone_calculate',
            'cel_property_calculate' => 'cel_property_calculate',
            'cel_driver_calculate' => 'cel_driver_calculate',
            'address_calculate' => 'address_calculate',
            'plate_calculate' => 'plate_calculate',
            'engine_calculate' => 'engine_calculate',
            'chassis_calculate' => 'chassis_calculate',
            'brand_calculate' => 'brand_calculate',
            'model_calculate' => 'model_calculate',
            'year_car_calculate' => 'year_car_calculate',
            'color_calculate' => 'color_calculate',
            'km_calculate' => 'km_calculate',
            'observation_calculate' => 'observation_calculate',
            'company_id' => Company::all()->random()->id
        ];
    }
}
