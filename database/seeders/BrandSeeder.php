<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/brands.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Brand::create([
                'number' => $value->id,
                'name' => $value->name,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
