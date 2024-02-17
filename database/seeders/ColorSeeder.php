<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/colors.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Color::create([
                'number' => $value->id,
                'name' => $value->name,
                'hex' => $value->hex,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
