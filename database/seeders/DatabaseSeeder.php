<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Box;
use App\Models\Brand;
use App\Models\Calculate;
use App\Models\Car;
use App\Models\Client;
use App\Models\Color;
use App\Models\Company;
use App\Models\Example;
use App\Models\Movement;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Service;
use App\Models\User;
use App\Models\Year;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Storage::deleteDirectory('companies');
        Storage::makeDirectory('companies');
        Storage::deleteDirectory('boxes');
        Storage::createDirectory('boxes');
        Storage::deleteDirectory('clients');
        Storage::createDirectory('clients');
        Storage::deleteDirectory('products');
        Storage::createDirectory('products');
        Storage::deleteDirectory('services');
        Storage::createDirectory('services');
        Storage::deleteDirectory('users');
        Storage::createDirectory('users');
        Storage::deleteDirectory('cars');
        Storage::createDirectory('cars');

        Company::factory(3)->create();
        User::factory(10)->create();
        $this->call([
            CompanySeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
        ]);

        Product::factory(50)->create();
        Service::factory(50)->create();
        Color::factory(10)->create();
        Year::factory(10)->create();
        Example::factory(10)->create();
        Brand::factory(10)->create();
        Client::factory(50)->create();
        Car::factory(100)->create();
        Box::factory(10)->create();
        Sale::factory(600)->create();
        Payment::factory(500)->create();
        Movement::factory(500)->create();
        $this->call(SaleSeeder::class);
        Calculate::factory(50)->create();
        $this->call(CalculateSeeder::class);
    }
}
