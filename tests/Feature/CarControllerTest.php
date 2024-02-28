<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Client;
use App\Models\Color;
use App\Models\Company;
use App\Models\Example;
use App\Models\Year;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cars()
    {
        $company = Company::factory()->create();
        Client::factory()->create();
        Example::factory()->create();
        Color::factory()->create();
        Brand::factory()->create();
        Year::factory()->create();
        Car::factory(5)->create();
        $postData = [
            'company_id' => $company->id,
            'search' => '',
            'perPage' => 'all'
        ];
        $response = $this->post('/mec/getCars', $postData);
        $response->assertStatus(200);
    }

    public function test_get_car()
    {
        Company::factory()->create();
        Client::factory()->create();
        Example::factory()->create();
        Color::factory()->create();
        Brand::factory()->create();
        Year::factory()->create();
        $car = Car::factory()->create();
        $response = $this->post('/mec/getCar/' . $car->id);
        $response->assertStatus(200);
    }

    public function test_register_car()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $example = Example::factory()->create();
        $color = Color::factory()->create();
        $brand =  Brand::factory()->create();
        $year = Year::factory()->create();
        $postData = [
            'plate' => 'NX-S5A2',
            'engine' => 'NKA1142',
            'chassis' => 'NSN-AS2255',
            'client_id' => $client->id,
            'example_id' => $example->id,
            'color_id' => $color->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/registerCar', $postData);
        $response->assertStatus(201);
        $this->assertDatabaseHas('cars', [
            'plate' => 'NX-S5A2',
            'engine' => 'NKA1142',
            'chassis' => 'NSN-AS2255',
            'client_id' => $client->id,
            'example_id' => $example->id,
            'color_id' => $color->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
        ]);
    }

    public function test_update_car()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $example = Example::factory()->create();
        $color = Color::factory()->create();
        $brand =  Brand::factory()->create();
        $year = Year::factory()->create();
        $car = Car::factory()->create();
        $postData = [
            'plate' => 'NX-S5A2',
            'engine' => 'NKA1142',
            'chassis' => 'NSN-AS2255',
            'client_id' => $client->id,
            'example_id' => $example->id,
            'color_id' => $color->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
            'company_id' => $company->id
        ];
        $response = $this->post('/mec/updateCar/' . $car->id, $postData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('cars', [
            'plate' => 'NX-S5A2',
            'engine' => 'NKA1142',
            'chassis' => 'NSN-AS2255',
            'client_id' => $client->id,
            'example_id' => $example->id,
            'color_id' => $color->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
        ]);
    }

    public function test_delete_car()
    {
        $company = Company::factory()->create();
        $client = Client::factory()->create();
        $example = Example::factory()->create();
        $color = Color::factory()->create();
        $brand =  Brand::factory()->create();
        $year = Year::factory()->create();
        $car = Car::factory()->create();
        $response = $this->delete('/mec/deleteCar/' . $car->id);
        $response->assertStatus(200);
        // $this->assertDatabaseEmpty('cars', $car);
    }
}
