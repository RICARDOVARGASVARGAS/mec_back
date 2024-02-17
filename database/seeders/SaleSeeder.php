<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/sales.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Sale::create([
                'number' => $value->id,
                'km'  => $value->km,
                'entry_date'  => $value->entry_date == "" ? null : $value->entry_date,
                'exit_date'  => $value->exit_date == "" ? null : $value->exit_date,
                'payment_date'  => null,
                'discount'  => $value->discount,
                'status'  => $value->status,
                'client_id'  => $value->client_id == 0 ? null : $value->client_id,
                'car_id'    => $value->car_id,
                'company_id'  => $value->company_id
            ]);
        }
    }
}
