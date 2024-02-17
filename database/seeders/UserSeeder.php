<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get("database/data/users.json");
        $items = json_decode($json);

        foreach ($items as $key => $value) {
            User::create([
                'number' => $value->id,
                'names' => $value->names,
                'surnames' => $value->surnames,
                'phone' => $value->phone,
                'image' => null,
                'email' => $value->email,
                'status' =>  $value->status,
                'role' => 'user',
                'password' => $value->password,
                'company_id' => $value->company_id,
            ]);
        }
    }
}
