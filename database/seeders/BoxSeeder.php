<?php

namespace Database\Seeders;

use App\Models\Box;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BoxSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/boxes.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Box::create([
                'number' => $value->id,
                'name' => $value->name,
                'image' => null,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
