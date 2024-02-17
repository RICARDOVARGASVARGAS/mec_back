<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SaleServiceSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/sale_service.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            DB::table('sale_service')->insert([
                'id' => $value->id,
                'price_service' => $value->price_service,
                'date_service' => $value->date_service,
                'sale_id' => $value->sale_id,
                'service_id' => $value->service_id,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at
            ]);
        }
    }
}
