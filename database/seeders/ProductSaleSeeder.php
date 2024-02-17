<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductSaleSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/product_sale.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            DB::table('product_sale')->insert([
                'id' => $value->id,
                'quantity' => $value->quantity,
                'price_buy' => $value->price_buy,
                'price_sell' => $value->price_sell,
                'date_sale' => $value->date_sale,
                'product_id' => $value->product_id,
                'sale_id' => $value->sale_id,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at
            ]);
        }
    }
}
