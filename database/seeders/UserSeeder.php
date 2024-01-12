<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'names' => 'Ricardo',
            'surnames' => 'Vargas',
            'email' => 'admin@gmail.com',
            'phone' => '123456789',
            'status' => 'active',
            'role' => 'admin',
            'password' => Hash::make('75469478'),
            'company_id' => Company::all()->random()->id
        ]);
    }
}
