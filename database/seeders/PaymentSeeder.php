<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/payments.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            Payment::create([
                'number' => $value->id,
                'detail'  => $value->detail,
                'amount'  => $value->amount,
                'date_payment'  => $value->date_payment,
                'sale_id'  => $value->sale_id,
                'box_id'  => $value->box_id
            ]);
        }
    }
}
