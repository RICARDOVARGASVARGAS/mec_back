<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/products.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Product::create([
                'number'  => $value->id,
                'name'   => $value->name,
                'ticket'  => $value->ticket,
                'price_buy'  => $value->price_buy,
                'price_sell'  => $value->price_sell,
                'image'  => null,
                'company_id'  => $value->company_id,
            ]);
        }
    }
}
