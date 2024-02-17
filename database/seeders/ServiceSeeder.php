<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/services.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Service::create([
                'number' => $value->id,
                'name' => $value->name,
                'ticket' => $value->ticket,
                'image' => null,
                'company_id' => $value->company_id
            ]);
        }
    }
}
