<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/cars.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Car::create([
                'number'  => $value->id,
                'plate'  => $value->plate,
                'engine'  => $value->engine,
                'chassis'  => $value->chassis,
                'image'    => null,
                'client_id'  => $value->client_id,
                'example_id'  => $value->example_id,
                'color_id'  => $value->color_id,
                'brand_id'  => $value->brand_id,
                'year_id'  => $value->year_id
            ]);
        }
    }
}
