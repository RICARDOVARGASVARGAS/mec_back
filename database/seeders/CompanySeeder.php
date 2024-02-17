<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // $json = File::get("database/data/companies.json");
        // $items = json_decode($json);

        // foreach ($items as $key => $value) {
            Company::create([
                "name" => 'Lisac Motors',
                'image' => null,
                'phone' => '901-278-101',
                'address' => 'Jr. Santa Rosa, Barrio Salinas.',
                'account_one' => 'BANCO DE LA NACIÓN: 04-195-308603',
                'account_two' => 'CUENTA BCP: 20591954286001',
                'account_three' => 'BBVA: 0011-0814-0209695338'
            ]);
        // }
    }
}
