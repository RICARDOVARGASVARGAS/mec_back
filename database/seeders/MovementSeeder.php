<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MovementSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/movements.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Movement::create([
                'number'  => $value->id,
                'amount'  => $value->amount,
                'detail'  => $value->detail,
                'date_movement'  => $value->date_movement,
                'client_id'  => $value->client_id == 0 ? null : $value->client_id,
                'box_id'  => $value->box_id
            ]);
        }
    }
}
