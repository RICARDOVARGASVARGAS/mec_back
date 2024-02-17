<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/clients.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Client::create([
                'number' => $value->id,
                'document' => $value->document,
                'name' => $value->name,
                'surname' => $value->surname,
                'last_name' => $value->last_name,
                'phone' => $value->phone,
                'email' => $value->email,
                'address' => $value->address,
                'image' => null,
                'company_id' =>  $value->company_id,
            ]);
        }
    }
}
