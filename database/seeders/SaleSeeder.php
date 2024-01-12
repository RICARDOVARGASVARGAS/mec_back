<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $sales = Sale::all();

        foreach ($sales as $sale) {
            $products = Product::where('company_id', $sale->company_id)->inRandomOrder()->take(rand(1, 10))->pluck('id')->toArray();
            $services = Service::where('company_id', $sale->company_id)->inRandomOrder()->take(rand(1, 10))->pluck('id')->toArray();

            foreach ($products as $product) {
                $sale->products()->attach(
                    $product,
                    [
                        'quantity' => rand(1, 10),
                        'price_buy' => rand(1, 10),
                        'price_sell' => rand(1, 10),
                        'date_sale' => date('Y-m-d')
                    ],
                );
            }

            foreach ($services as $service) {
                $sale->services()->attach(
                    $service,
                    [
                        'price_service' => mt_rand(4, 1000) / 10,
                        'date_service' => date('Y-m-d')
                    ],
                );
            }
        }
    }
}
