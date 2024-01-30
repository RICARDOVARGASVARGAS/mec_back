<?php

namespace Database\Seeders;

use App\Models\Calculate;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalculateSeeder extends Seeder
{
    public function run(): void
    {
        $calculates = Calculate::all();

        foreach ($calculates as $calculate) {
            $products = Product::where('company_id', $calculate->company_id)->inRandomOrder()->take(rand(1, 10))->pluck('id')->toArray();
            $services = Service::where('company_id', $calculate->company_id)->inRandomOrder()->take(rand(1, 10))->pluck('id')->toArray();

            foreach ($products as $product) {
                $calculate->products()->attach(
                    $product,
                    [
                        'quantity' => rand(1, 10),
                        'price_sell' => rand(1, 10)
                    ],
                );
            }

            foreach ($services as $service) {
                $calculate->services()->attach(
                    $service,
                    [
                        'price_service' => mt_rand(4, 1000) / 10,
                    ],
                );
            }
        }
    }
}
