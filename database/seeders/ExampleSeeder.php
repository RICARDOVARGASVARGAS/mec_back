<?php

namespace Database\Seeders;

use App\Models\Example;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ExampleSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/examples.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Example::create([
                'number' => $value->id,
                'name' => $value->name,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
