<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class YearSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/years.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Year::create([
                'number' => $value->id,
                'name' => $value->name,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
